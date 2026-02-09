<?php
if (!isset($SITE, $NAV, $BRAND)) { http_response_code(500); echo "Site config not loaded."; exit; }

$pageTitle = $pageTitle ?? $SITE['name'];
$pageDesc  = $pageDesc  ?? $SITE['tagline'];

$current = current_path();

// Icons config (optional in case older pages load config without it)
$ICONS = $ICONS ?? [];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pageTitle . ' | ' . $SITE['name']) ?></title>
  <meta name="description" content="<?= e($pageDesc) ?>">
  <!-- Open Graph / Facebook / LinkedIn etc. -->
  <meta property="og:title" content="<?= e($pageTitle) ?> | <?= e($SITE['name']) ?>">
  <meta property="og:description" content="<?= e($og_description ?? $pageDesc) ?>">
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?= e('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>">
  <meta property="og:site_name" content="<?= e($SITE['name']) ?>">
  <meta property="og:image" content="<?= e(asset_url($og_image ?? $SOCIAL_SHARING['default_image'])) ?>">
  <meta property="og:image:alt" content="<?= e($og_image_alt ?? $SOCIAL_SHARING['default_image_alt']) ?>">  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
<?php if (!empty($twitterCreator ?? $SOCIAL['x']['handle'] ?? $SOCIAL_SHARING['twitter_handle'])): ?>
  <meta name="twitter:creator" content="@<?= e($twitterCreator ?? $SOCIAL['x']['handle'] ?? $SOCIAL_SHARING['twitter_handle']) ?>">
<?php endif; ?>
  
  <!-- Twitter / X Cards (recommended but optional fallback) -->
  <meta name="twitter:card" content="summary_large_image">
<?php if (!empty($SOCIAL['x']['handle'])): ?>
  <meta name="twitter:site" content="@<?= e($SOCIAL['x']['handle']) ?>">
<?php endif; ?>
  <meta name="twitter:title" content="<?= e($pageTitle) ?> | <?= e($SITE['name']) ?>">
  <meta name="twitter:description" content="<?= e($og_description ?? $pageDesc) ?>">
  <meta name="twitter:image" content="<?= e(asset_url($og_image ?? $SOCIAL_SHARING['default_image'])) ?>">
  <meta name="twitter:image:alt" content="<?= e($og_image_alt ?? $SOCIAL_SHARING['default_image_alt']) ?>">
<link rel="stylesheet" href="<?= e(asset_url('/assets/css/site.css?v=4')) ?>">

  <?php if (!empty($ICONS['favicon_ico'])): ?>
    <link rel="icon" type="image/x-icon" href="<?= e($ICONS['favicon_ico']) ?>">
  <?php endif; ?>

  <?php if (!empty($ICONS['favicon_16'])): ?>
    <link rel="icon" type="image/png" sizes="16x16" href="<?= e($ICONS['favicon_16']) ?>">
  <?php endif; ?>

  <?php if (!empty($ICONS['favicon_32'])): ?>
    <link rel="icon" type="image/png" sizes="32x32" href="<?= e($ICONS['favicon_32']) ?>">
  <?php endif; ?>

  <?php if (!empty($ICONS['favicon_96'])): ?>
    <link rel="icon" type="image/png" sizes="96x96" href="<?= e($ICONS['favicon_96']) ?>">
  <?php endif; ?>

  <?php if (!empty($ICONS['apple_180'])): ?>
    <link rel="apple-touch-icon" sizes="180x180" href="<?= e($ICONS['apple_180']) ?>">
  <?php endif; ?>

  <?php if (!empty($ICONS['apple_152'])): ?>
    <link rel="apple-touch-icon" sizes="152x152" href="<?= e($ICONS['apple_152']) ?>">
  <?php endif; ?>

  <?php if (!empty($ICONS['apple_144'])): ?>
    <link rel="apple-touch-icon" sizes="144x144" href="<?= e($ICONS['apple_144']) ?>">
  <?php endif; ?>

  <?php if (!empty($ICONS['apple_120'])): ?>
    <link rel="apple-touch-icon" sizes="120x120" href="<?= e($ICONS['apple_120']) ?>">
  <?php endif; ?>

  <?php if (!empty($ICONS['apple_114'])): ?>
    <link rel="apple-touch-icon" sizes="114x114" href="<?= e($ICONS['apple_114']) ?>">
  <?php endif; ?>

  <?php if (!empty($ICONS['ms_tile_color'])): ?>
    <meta name="msapplication-TileColor" content="<?= e($ICONS['ms_tile_color']) ?>">
  <?php endif; ?>

  <?php if (!empty($ICONS['ms_tile_image'])): ?>
    <meta name="msapplication-TileImage" content="<?= e($ICONS['ms_tile_image']) ?>">
  <?php endif; ?>

  <?php if (!empty($ICONS['theme_color'])): ?>
    <meta name="theme-color" content="<?= e($ICONS['theme_color']) ?>">
  <?php endif; ?>
</head>
<body>
<header class="site-header">
  <div class="container header-inner">
    <a class="brand" href="/index.php">
      <img class="brand-logo"
           src="<?= e($BRAND['logo_path']) ?>"
           alt="<?= e($BRAND['logo_alt']) ?>"
           loading="eager">

<span class="brand-text">
  <span class="brand-name"><?= e($SITE['short_name']) ?></span>

  <?php if (!empty($SITE['subheading'])): ?>
    <span class="brand-subheading">
      <?= e($SITE['subheading']) ?>
    </span>
  <?php endif; ?>
</span>

    </a>


<?php
// Filter + normalise nav (supports show_in_nav + children)
$nav = [];
foreach ($NAV as $it) {
  if (($it['show_in_nav'] ?? true) !== true) continue;
  $it['children'] = (!empty($it['children']) && is_array($it['children'])) ? $it['children'] : [];
  // filter children too
  if ($it['children']) {
    $kids = [];
    foreach ($it['children'] as $ch) {
      if (($ch['show_in_nav'] ?? true) !== true) continue;
      $kids[] = $ch;
    }
    $it['children'] = $kids;
  }
  $nav[] = $it;
}

function nav_is_active(string $current, string $href): bool {
  $hrefPath = parse_url($href, PHP_URL_PATH) ?: $href;
  if ($hrefPath === '/index.php' || $hrefPath === '/') return $current === '/index.php' || $current === '/';
  $base = rtrim(str_replace('.php', '', $hrefPath), '/');
  return $current === $hrefPath || str_starts_with(rtrim($current, '/'), $base);
}

function item_or_children_active(string $current, array $item): bool {
  if (!empty($item['href']) && nav_is_active($current, (string)$item['href'])) return true;
  if (!empty($item['children'])) {
    foreach ($item['children'] as $ch) {
      if (!empty($ch['href']) && nav_is_active($current, (string)$ch['href'])) return true;
    }
  }
  return false;
}
?>

<nav class="nav" aria-label="Primary">
  <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="mobile-menu">
    Menu
  </button>

  <!-- Desktop -->
  <ul class="nav-menu" role="list">
    <?php foreach ($nav as $item): ?>
      <?php
        $hasChildren = !empty($item['children']);
        $isActive = item_or_children_active($current, $item);
        $isCta = !empty($item['cta']);
      ?>
      <li class="nav-item<?= $hasChildren ? ' has-children' : '' ?>">
        <a
          class="nav-link<?= $isActive ? ' active' : '' ?><?= $isCta ? ' nav-cta' : '' ?>"
          href="<?= e((string)$item['href']) ?>"
          <?= $isActive ? 'aria-current="page"' : '' ?>
        >
          <?= e((string)$item['label']) ?>
        </a>

        <?php if ($hasChildren): ?>
          <ul class="nav-submenu" role="list" aria-label="<?= e((string)$item['label']) ?>">
            <?php foreach ($item['children'] as $ch): ?>
              <?php $cActive = nav_is_active($current, (string)$ch['href']); ?>
              <li>
                <a class="nav-sublink<?= $cActive ? ' active' : '' ?>"
                   href="<?= e((string)$ch['href']) ?>"
                   <?= $cActive ? 'aria-current="page"' : '' ?>>
                  <?= e((string)$ch['label']) ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ul>
</nav>

<!-- Mobile off-canvas -->
<div class="mobile-menu" id="mobile-menu" hidden>
  <div class="mobile-menu__panel" role="dialog" aria-label="Menu">
    <button class="mobile-menu__close" type="button">Close</button>

    <ul class="mobile-links" role="list">
      <?php foreach ($nav as $item): ?>
        <?php $hasChildren = !empty($item['children']); ?>
        <li class="mobile-item">
          <?php if ($hasChildren): ?>
            <details class="mobile-details">
              <summary class="mobile-summary"><?= e((string)$item['label']) ?></summary>
              <ul class="mobile-sublinks" role="list">
                <li><a class="mobile-link" href="<?= e((string)$item['href']) ?>"><?= e((string)$item['label']) ?> overview</a></li>
                <?php foreach ($item['children'] as $ch): ?>
                  <li><a class="mobile-link" href="<?= e((string)$ch['href']) ?>"><?= e((string)$ch['label']) ?></a></li>
                <?php endforeach; ?>
              </ul>
            </details>
          <?php else: ?>
            <a class="mobile-link<?= !empty($item['cta']) ? ' mobile-cta' : '' ?>"
               href="<?= e((string)$item['href']) ?>">
              <?= e((string)$item['label']) ?>
            </a>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <div class="mobile-menu__backdrop" aria-hidden="true"></div>
</div>
