<?php
declare(strict_types=1);
require __DIR__ . '/includes/config.php';

$pageTitle = 'Calendar';

$dbPath = $CALENDAR['db_path'];
$events = [];
$sources = [];
$selectedSourceId = null;

// Optional filter: ?source=123
$sourceParam = filter_input(INPUT_GET, 'source', FILTER_VALIDATE_INT);
if (is_int($sourceParam) && $sourceParam > 0) {
  $selectedSourceId = $sourceParam;
}

/**
 * Map a source name to a section colour class.
 * Non-section / group events will fall back to 'default'.
 */
function source_badge_class(string $sourceName): string {
  $s = mb_strtolower($sourceName);

  if (str_contains($s, 'squirrel')) return 'squirrels';
  if (str_contains($s, 'beaver'))   return 'beavers';
  if (str_contains($s, 'cub'))      return 'cubs';
  if (str_contains($s, 'explorer')) return 'explorers';
  if (str_contains($s, 'network'))  return 'network';

  // Treat “scout(s)” as Scouts section (but leave “scout centre” etc as default if you prefer)
  if (preg_match('/\bscout(s)?\b/u', $s) === 1) return 'scouts';

  return 'default';
}

if (is_file($dbPath)) {
  $pdo = new PDO('sqlite:' . $dbPath, null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ]);

  // Build filter UI from active sources
  $sources = $pdo->query("
    SELECT id, name
    FROM calendar_sources
    WHERE active = 1
    ORDER BY name ASC
  ")->fetchAll();

  $from = (new DateTimeImmutable('now', new DateTimeZone('UTC')))->format('Y-m-d\TH:i:s\Z');
  $to   = (new DateTimeImmutable('+120 days', new DateTimeZone('UTC')))->format('Y-m-d\TH:i:s\Z');

  $sql = "
    SELECT
      e.title,
      e.start_utc,
      e.end_utc,
      e.location,
      e.description,
      e.visibility,
      s.id   AS source_id,
      s.name AS source_name
    FROM calendar_events e
    JOIN calendar_sources s ON s.id = e.source_id
    WHERE e.start_utc >= :from AND e.start_utc <= :to
      AND e.visibility IN ('members','public')
      AND s.active = 1
  ";

  $params = [':from' => $from, ':to' => $to];

  if ($selectedSourceId !== null) {
    $sql .= " AND s.id = :source_id ";
    $params[':source_id'] = $selectedSourceId;
  }

  $sql .= " ORDER BY e.start_utc ASC LIMIT 800 ";

  $stmt = $pdo->prepare($sql);
  $stmt->execute($params);
  $events = $stmt->fetchAll();
}

require __DIR__ . '/partials/header.php';
?>

<section class="hero">
  <div class="container">
    <h1>Calendar</h1>
    <p class="lead">Consolidated events from OSM feeds. Updated hourly.</p>

    <p style="display:flex; gap:0.75rem; flex-wrap:wrap; margin-top:1rem;">
      <a class="btn" href="/members.php">Back to Members</a>
    </p>
  </div>
</section>

<section class="section">
  <div class="container">

    <?php if (is_file($dbPath) && $sources): ?>
      <form method="get" class="calendar-filter" style="margin-bottom:1rem; display:flex; gap:0.75rem; flex-wrap:wrap; align-items:end;">
        <div>
          <label for="source" class="hint" style="display:block; margin-bottom:0.25rem;">Filter by source</label>
          <select id="source" name="source">
            <option value="">All sources</option>
            <?php foreach ($sources as $src): ?>
              <?php $id = (int)$src['id']; ?>
              <option value="<?= e((string)$id) ?>" <?= ($selectedSourceId === $id) ? 'selected' : '' ?>>
                <?= e((string)$src['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div style="display:flex; gap:0.5rem;">
          <button class="btn" type="submit">Apply</button>
          <?php if ($selectedSourceId !== null): ?>
            <a class="btn" href="/calendar.php">Clear</a>
          <?php endif; ?>
        </div>
      </form>
    <?php endif; ?>

    <?php if (!$events): ?>
      <div class="card">
        <h2>No events yet</h2>
        <p>Run the fetch script once, then refresh this page.</p>
        <p class="hint">Command: <code>php cron_fetch_calendars.php</code></p>
      </div>
    <?php else: ?>

      <div style="display:grid; gap:0.75rem;">
        <?php
        $lastDay = '';
        foreach ($events as $ev):
          try {
            $dt = new DateTimeImmutable((string)$ev['start_utc'], new DateTimeZone('UTC'));
            $day = $dt->setTimezone(new DateTimeZone('Europe/London'))->format('l j F Y');
          } catch (Throwable $t) {
            $day = 'Date';
          }

          if ($day !== $lastDay):
            if ($lastDay !== '') echo '</div>';
        ?>
          <h2 style="margin: 1.75rem 0 0.75rem;"><?= e($day) ?></h2>
          <div style="display:grid; gap:0.75rem;">
        <?php
            $lastDay = $day;
          endif;

          $sourceName = (string)($ev['source_name'] ?? 'Calendar');
          $badgeClass = source_badge_class($sourceName);
        ?>

            <div class="event">
              <div class="event-title">
                <span class="badge badge--source badge--<?= e($badgeClass) ?>"><?= e($sourceName) ?></span>
                <?= e((string)$ev['title']) ?>
                <?= ((string)$ev['visibility'] === 'public')
                  ? ' <span class="badge badge--public">Public</span>'
                  : '' ?>
              </div>

              <div class="event-meta">
                <?= e(iso_to_pretty((string)$ev['start_utc'])) ?>
                <?php if (!empty($ev['end_utc'])): ?>–<?= e(iso_to_pretty((string)$ev['end_utc'])) ?><?php endif; ?>
                <?php if (!empty($ev['location'])): ?> · <?= e((string)$ev['location']) ?><?php endif; ?>
              </div>

              <?php if (!empty($ev['description'])): ?>
                <div class="hint">
                  <?= nl2br(e(mb_substr((string)$ev['description'], 0, 240))) ?><?= mb_strlen((string)$ev['description']) > 240 ? '…' : '' ?>
                </div>
              <?php endif; ?>
            </div>

        <?php endforeach; ?>
        <?php if ($lastDay !== '') echo '</div>'; ?>
      </div>

    <?php endif; ?>
  </div>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>
