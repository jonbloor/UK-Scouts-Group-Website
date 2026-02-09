<?php
declare(strict_types=1);

function e(string|null $value): string {
  return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function current_path(): string {
  $p = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
  return $p ?: '/';
}

function asset_url(string $webPath): string {
  // $webPath like '/assets/css/site.css'
  $filePath = rtrim($_SERVER['DOCUMENT_ROOT'] ?? '', '/') . $webPath;
  if ($filePath && is_file($filePath)) {
    return $webPath . '?v=' . filemtime($filePath);
  }
  return $webPath;
}

function iso_to_pretty(string $iso): string {
  // ISO stored as UTC "YYYY-MM-DDTHH:MM:SSZ"
  try {
    $dt = new DateTimeImmutable($iso, new DateTimeZone('UTC'));
    $local = $dt->setTimezone(new DateTimeZone('Europe/London'));
    return $local->format('D j M Y, H:i');
  } catch (Throwable $e) {
    return $iso;
  }
}

function generate_csrf_token(): string {
  if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  }
  return $_SESSION['csrf_token'];
}

function validate_csrf_token(string $token): bool {
  return hash_equals($_SESSION['csrf_token'] ?? '', $token);
}

if (!function_exists('inline_svg')) {
  /**
   * Inline a local SVG file and optionally add class/attributes to the <svg> tag.
   *
   * Backwards compatible:
   * - inline_svg($path, 'my-class')
   * - inline_svg($path, ['class' => 'my-class', 'role' => 'img', 'aria-label' => 'Logo'])
   */
  function inline_svg(string $filePath, string|array $classOrAttrs = ''): string {
    if ($filePath === '' || !is_file($filePath) || !is_readable($filePath)) {
      return '';
    }

    $svg = file_get_contents($filePath);
    if ($svg === false || $svg === '') return '';

    if (!preg_match('/<svg\b[^>]*>/i', $svg)) return '';

    // Strip XML header if present
    $svg = preg_replace('/^\s*<\?xml[^>]*>\s*/i', '', $svg);

    $attrs = [];
    if (is_string($classOrAttrs) && $classOrAttrs !== '') {
      $attrs['class'] = $classOrAttrs;
    } elseif (is_array($classOrAttrs)) {
      $attrs = $classOrAttrs;
    }

    if (!empty($attrs)) {
      $attrStr = '';
      foreach ($attrs as $k => $v) {
        if ($v === null || $v === '') continue;
        $k = preg_replace('/[^a-zA-Z0-9:_-]/', '', (string)$k);
		$v = e((string)$v);
        $attrStr .= ' ' . $k . '="' . $v . '"';
      }
      $svg = preg_replace('/<svg\b([^>]*)>/i', '<svg$1' . $attrStr . '>', $svg, 1);
    }

    return $svg;
  }
}
