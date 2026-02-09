<?php
// partials/footer.php
?>
  </main>
  <?php
  if (!isset($SITE) || !is_array($SITE)) {
    http_response_code(500);
    echo "Site config not loaded.";
    exit;
  }
  require_once __DIR__ . '/../includes/social-icons.php'; // For inline icons

  $FOOTER = $FOOTER ?? [];
  $charity = $SITE['charity'] ?? [];
  if (!is_array($charity)) $charity = [];
  $charityNumber = trim((string)($charity['number'] ?? ''));
  $charityName = trim((string)($charity['registered_name'] ?? ''));
  $charityOffice = trim((string)($charity['registered_office'] ?? ''));
  $charityUrl = trim((string)($charity['register_url'] ?? ''));
  $charityJurisdiction = trim((string)($charity['jurisdiction'] ?? 'England and Wales')) ?: 'England and Wales';
  $hasFullCharityStatement = ($charityNumber !== '' && $charityName !== '' && $charityOffice !== '');
  $showCharityStatement = (bool)($FOOTER['show_charity_statement'] ?? true);

  // Address line from FOOTER config (e.g. correspondence or display address)
  $addressLine = trim((string)($FOOTER['address_line'] ?? ''));

  // Decide whether to show separate address line
  $normalizedOffice = preg_replace('/\s+/', ' ', strtolower($charityOffice));
  $normalizedAddress = preg_replace('/\s+/', ' ', strtolower($addressLine));
  $showSeparateAddress = ($addressLine !== '' && $normalizedAddress !== $normalizedOffice);

  $identity = $FOOTER['identity'] ?? [];
  if (!is_array($identity)) $identity = [];

  $columns = $FOOTER['columns'] ?? [];
  if (!is_array($columns)) $columns = [];

  $social_links = $SOCIAL ?? []; // From config.php
  ?>
  <footer class="site-footer">
    <div class="container">

      <!-- Top: Logo + Follow us -->
      <div class="footer-top">
        <div class="footer-logo">
          <?php
			$logoWebPath = (string)($BRAND['logo_path'] ?? '');
			$logoFile    = $logoWebPath ? (realpath(__DIR__ . '/..' . $logoWebPath) ?: '') : '';
			echo inline_svg($logoFile, [
  				'class' => 'brand-logo',
  				'role'  => 'img',
  				'aria-label' => 'Scouts logo',
				]);
          ?>
        </div>
        <?php if (!empty($social_links)): ?>
          <div class="footer-follow">
            <div class="footer-follow-title">Follow us</div>
            <div class="footer-social-icons">
              <?php foreach ($social_links as $platform => $item): ?>
                <?php if (!empty($item['url'])): ?>
                  <a href="<?= e($item['url']) ?>" aria-label="<?= e($item['label'] ?? ucfirst($platform)) ?>" target="_blank" rel="noopener noreferrer">
                    <?= social_icon($platform) ?>
                  </a>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>

      <!-- Main columns -->
      <div class="footer-columns">
        <?php foreach ($columns as $col): ?>
          <div class="footer-column">
            <h3 class="footer-column-title"><?= e($col['title']) ?></h3>
            <ul class="footer-column-list">
              <?php foreach ($col['items'] as $i => $item): ?>
                <?php
                  $label = trim((string)($item['label'] ?? ''));
                  $href = trim((string)($item['href'] ?? ''));
                  $times = $item['times'] ?? [];
                  if (!is_array($times)) $times = [];
                  $id = 'footer-times-' . preg_replace('/[^a-z0-9\-]/i', '-', ($label ?: (string)$i));
                  if ($col['type'] === 'sections' && empty($href)) {
                    $href = '/section.php?slug=' . rawurlencode($item['slug'] ?? '');
                  }
                ?>
                <?php if ($label): ?>
                  <li>
                    <?php if ($col['type'] === 'sections' && !empty($times)): ?>
                      <div class="footer-section-row">
                        <a href="<?= e($href) ?>"><?= e($label) ?></a>
                        <button class="footer-section-toggle" type="button" aria-expanded="false" aria-controls="<?= e($id) ?>">
                          <span class="arrow" aria-hidden="true"></span>
                        </button>
                      </div>
                      <div class="footer-section-times" id="<?= e($id) ?>" hidden>
                        <ul>
                          <?php foreach ($times as $time): ?>
                            <li><?= e($time) ?></li>
                          <?php endforeach; ?>
                        </ul>
                      </div>
                    <?php else: ?>
                      <?php if ($href): ?>
                        <a href="<?= e($href) ?>"><?= e($label) ?></a>
                      <?php else: ?>
                        <?= e($label) ?>
                      <?php endif; ?>
                    <?php endif; ?>
                  </li>
                <?php endif; ?>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Bottom -->
      <div class="footer-bottom">
        <?php if ($showCharityStatement && $hasFullCharityStatement): ?>
          <div class="footer-charity">
            <?= e($charityName) ?> is a registered charity in <?= e($charityJurisdiction) ?>
            (number <?php if ($charityUrl !== ''): ?><a href="<?= e($charityUrl) ?>" target="_blank" rel="noopener noreferrer"><?= e($charityNumber) ?></a><?php else: ?><?= e($charityNumber) ?><?php endif; ?>).<br>
            Registered office: <?= e($charityOffice) ?>.
            <?php if ($showSeparateAddress): ?>
              <br>Correspondence address: <?= e($addressLine) ?>.
            <?php endif; ?>
          </div>
        <?php endif; ?>
        <div class="footer-meta-row">
          <div class="footer-copyright">
            © <?= date('Y') ?> <?= e($SITE['short_name']) ?>. All rights reserved.
          </div>
          <div class="footer-policies">
            <a href="/privacy.php">Privacy Policy</a> |
            <a href="/cookie-policy.php">Cookie Policy</a> |
            <a href="/site-map.php">Site Map</a>
          </div>
        </div>
      </div>

    </div>
  </footer>
<script src="<?= e(asset_url('/assets/js/site.js?v=2')) ?>" defer></script>
</body>
</html>
