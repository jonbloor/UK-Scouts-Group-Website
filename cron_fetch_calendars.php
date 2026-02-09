<?php
declare(strict_types=1);
require __DIR__ . '/includes/config.php';

$dbPath = $CALENDAR['db_path'];
@mkdir(dirname($dbPath), 0775, true);

$pdo = new PDO('sqlite:' . $dbPath, null, null, [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

$pdo->exec("
CREATE TABLE IF NOT EXISTS calendar_sources (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name TEXT NOT NULL,
  url TEXT NOT NULL UNIQUE,
  active INTEGER NOT NULL DEFAULT 1,
  last_fetch_utc TEXT,
  last_status TEXT
);

CREATE TABLE IF NOT EXISTS calendar_events (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  source_id INTEGER NOT NULL,
  uid TEXT NOT NULL,
  title TEXT NOT NULL,
  start_utc TEXT NOT NULL,
  end_utc TEXT,
  location TEXT,
  description TEXT,
  visibility TEXT NOT NULL DEFAULT 'members',
  updated_utc TEXT NOT NULL,
  UNIQUE(uid, start_utc),
  FOREIGN KEY(source_id) REFERENCES calendar_sources(id)
);
");

function curl_get(string $url): string {
  $ch = curl_init($url);
  curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_TIMEOUT => 20,
    CURLOPT_USERAGENT => '4thashby-calendar-fetch/1.0',
  ]);
  $body = curl_exec($ch);
  $code = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
  $err  = curl_error($ch);
  curl_close($ch);

  if ($body === false || $code >= 400) {
    throw new RuntimeException("Fetch failed HTTP $code $err");
  }
  return (string)$body;
}

function unfold_ics(string $ics): array {
  $ics = str_replace(["\r\n", "\r"], "\n", $ics);
  $lines = explode("\n", $ics);
  $out = [];
  foreach ($lines as $line) {
    if ($line === '') continue;
    if (!empty($out) && (str_starts_with($line, ' ') || str_starts_with($line, "\t"))) {
      $out[count($out) - 1] .= ltrim($line);
    } else {
      $out[] = $line;
    }
  }
  return $out;
}

function parse_dt_to_utc_iso(string $raw): ?string {
  // Handles:
  // 20260203T190000Z
  // 20260203T190000
  // 20260203
  $raw = trim($raw);
  if ($raw === '') return null;

  try {
    if (preg_match('/^\d{8}T\d{6}Z$/', $raw)) {
      $dt = DateTimeImmutable::createFromFormat('Ymd\THis\Z', $raw, new DateTimeZone('UTC'));
      return $dt ? $dt->format('Y-m-d\TH:i:s\Z') : null;
    }
    if (preg_match('/^\d{8}T\d{6}$/', $raw)) {
      // assume Europe/London local time if no timezone
      $dt = DateTimeImmutable::createFromFormat('Ymd\THis', $raw, new DateTimeZone('Europe/London'));
      return $dt ? $dt->setTimezone(new DateTimeZone('UTC'))->format('Y-m-d\TH:i:s\Z') : null;
    }
    if (preg_match('/^\d{8}$/', $raw)) {
      // all-day: treat as start 00:00 local, convert to UTC
      $dt = DateTimeImmutable::createFromFormat('Ymd', $raw, new DateTimeZone('Europe/London'));
      return $dt ? $dt->setTime(0,0)->setTimezone(new DateTimeZone('UTC'))->format('Y-m-d\TH:i:s\Z') : null;
    }
  } catch (Throwable $e) {
    return null;
  }
  return null;
}

function parse_ics_events(string $ics): array {
  $lines = unfold_ics($ics);
  $events = [];
  $in = false;
  $cur = [];

  foreach ($lines as $line) {
    if ($line === 'BEGIN:VEVENT') { $in = true; $cur = []; continue; }
    if ($line === 'END:VEVENT') {
      if ($in && !empty($cur['UID']) && !empty($cur['DTSTART'])) $events[] = $cur;
      $in = false; $cur = []; continue;
    }
    if (!$in) continue;

    $parts = explode(':', $line, 2);
    if (count($parts) !== 2) continue;

    $left = $parts[0];
    $val  = $parts[1];

    $key = explode(';', $left, 2)[0]; // strip params
    $cur[$key] = $val;
  }

  return $events;
}

function normalise_text(?string $s): string {
  $s = (string)$s;
  $s = str_replace(['\n', '\N', '\,', '\;'], ["\n", "\n", ",", ";"], $s);
  return trim($s);
}

$nowUtc = (new DateTimeImmutable('now', new DateTimeZone('UTC')))->format('Y-m-d\TH:i:s\Z');

$publicKeywords = array_map('strtolower', $CALENDAR['public_keywords'] ?? []);
$publicUids = array_map('strtolower', $CALENDAR['public_uids'] ?? []);

// Source statements
$insSource = $pdo->prepare("INSERT OR IGNORE INTO calendar_sources(name,url,active) VALUES(?,?,1)");
$syncSourceName = $pdo->prepare("UPDATE calendar_sources SET name=?, active=1 WHERE url=?");
$getSource = $pdo->prepare("SELECT id FROM calendar_sources WHERE url=? LIMIT 1");
$updSource = $pdo->prepare("UPDATE calendar_sources SET last_fetch_utc=?, last_status=? WHERE id=?");

// Event upsert
$upsertEvent = $pdo->prepare("
INSERT INTO calendar_events(source_id, uid, title, start_utc, end_utc, location, description, visibility, updated_utc)
VALUES(:source_id,:uid,:title,:start_utc,:end_utc,:location,:description,:visibility,:updated_utc)
ON CONFLICT(uid, start_utc) DO UPDATE SET
  title=excluded.title,
  end_utc=excluded.end_utc,
  location=excluded.location,
  description=excluded.description,
  visibility=excluded.visibility,
  updated_utc=excluded.updated_utc
");

foreach (($CALENDAR['sources'] ?? []) as $src) {
  $name = (string)($src['name'] ?? 'Calendar feed');
  $url  = (string)($src['url'] ?? '');
  if ($url === '') continue;

  // Ensure row exists, then force name to match config each run (maintainable)
  $insSource->execute([$name, $url]);
  $syncSourceName->execute([$name, $url]);

  $getSource->execute([$url]);
  $row = $getSource->fetch();
  if (!$row) continue;
  $sourceId = (int)$row['id'];

  try {
    $ics = curl_get($url);
    $events = parse_ics_events($ics);

    $count = 0;
    foreach ($events as $ev) {
      $uid = normalise_text($ev['UID'] ?? '');
      $title = normalise_text($ev['SUMMARY'] ?? 'Event');
      $startRaw = normalise_text($ev['DTSTART'] ?? '');
      $endRaw   = normalise_text($ev['DTEND'] ?? '');
      $loc = normalise_text($ev['LOCATION'] ?? '');
      $desc = normalise_text($ev['DESCRIPTION'] ?? '');

      $startUtc = parse_dt_to_utc_iso($startRaw);
      $endUtc   = $endRaw ? parse_dt_to_utc_iso($endRaw) : null;
      if (!$uid || !$startUtc) continue;

      $visibility = 'members';
      $hay = strtolower($title . ' ' . $desc);
      if (in_array(strtolower($uid), $publicUids, true)) {
        $visibility = 'public';
      } else {
        foreach ($publicKeywords as $kw) {
          if ($kw !== '' && str_contains($hay, $kw)) { $visibility = 'public'; break; }
        }
      }

      $upsertEvent->execute([
        ':source_id' => $sourceId,
        ':uid' => $uid,
        ':title' => $title,
        ':start_utc' => $startUtc,
        ':end_utc' => $endUtc,
        ':location' => $loc ?: null,
        ':description' => $desc ?: null,
        ':visibility' => $visibility,
        ':updated_utc' => $nowUtc,
      ]);

      $count++;
    }

    $updSource->execute([$nowUtc, "OK: $count events", $sourceId]);
  } catch (Throwable $e) {
    $updSource->execute([$nowUtc, "ERROR: " . $e->getMessage(), $sourceId]);
  }
}

echo "Calendar fetch complete at $nowUtc\n";
