<?php
declare(strict_types=1);

require __DIR__ . '/includes/config.php';

// Optional social sharing overrides – uncomment and customise as needed later
// $og_image       = '/assets/img/hero-specific.jpg';
// $og_image_alt   = 'Description of this page’s hero image for social previews';
// $og_description = 'A more engaging share description for this specific page';

$pageTitle = 'Home';
require __DIR__ . '/partials/header.php';

$venueName = trim((string)($SITE['venue']['name'] ?? ''));
$venueArea = trim((string)($SITE['venue']['area'] ?? ''));
$venueTown = trim((string)($SITE['venue']['town'] ?? 'Ashby-de-la-Zouch'));
?>

<section class="hero">
  <div class="hero-media">
    <img
      src="<?= e(asset_url('/assets/img/img1.webp')) ?>"
      alt="Young people enjoying Scouts activities outdoors"
      width="1600"
      height="900"
      fetchpriority="high"
      decoding="async">
  </div>

  <div class="container hero-content">
    <h1>Ready for adventure with <?= e((string)($SITE['name'] ?? '4th Ashby Scout Group')) ?>?</h1>

    <p class="lead">
      Fun, friendship and skills for life for young people across
      <?= e((string)($SITE['venue']['town'] ?? 'Ashby-de-la-Zouch')) ?>.
    </p>

    <div class="hero-actions">
      <a class="btn primary" href="<?= e((string)($CTA['join_url'] ?? '/join.php')) ?>">Join the adventure</a>
      <a class="btn secondary btn-white" href="<?= e((string)($CTA['volunteer_url'] ?? '/volunteer.php')) ?>">Volunteer</a>
    </div>

    <p class="hero-note">Open to all. Inclusive, safe and volunteer-led.</p>
  </div>
</section>

<section class="section">
  <div class="container grid-3">
    <div class="card card--stack">
      <img
        src="<?= e(asset_url('/assets/img/img2.webp')) ?>"
        alt="Young people taking part in a Scouts activity"
        loading="lazy"
        decoding="async"
        width="1200"
        height="675">
      <h3>Which section is right for your child?</h3>
      <p>A simple guide to help you start the adventure – from Squirrels (4–5) to Explorers (14–18).</p>
      <a class="btn primary full-width" href="<?= e((string)($CTA['join_url'] ?? '/join.php')) ?>#which-section">Join the adventure</a>
    </div>

    <div class="card card--stack">
      <img
        src="<?= e(asset_url('/assets/img/img3.webp')) ?>"
        alt="Scouts celebrating after completing a challenge"
        loading="lazy"
        decoding="async"
        width="1200"
        height="675">
      <h3>Upcoming events</h3>
      <p>Public events, fundraisers, open evenings and key dates full of fun and community spirit.</p>
      <a class="btn primary full-width" href="/calendar.php">View events</a>
    </div>

    <div class="card card--stack">
      <img
        src="<?= e(asset_url('/assets/img/img4.webp')) ?>"
        alt="Volunteers and families sharing time together at Scouts"
        loading="lazy"
        decoding="async"
        width="1200"
        height="675">
      <h3>For current members</h3>
      <p>Calendars, policies, uniform info and resources for our amazing families and volunteers.</p>
      <a class="btn primary full-width" href="/members.php">Go to members area</a>
    </div>
  </div>
</section>

<section class="section bg-surface">
  <div class="container">
    <h2 class="text-center" style="margin-bottom: 2rem;">Explore our age groups</h2>

    <div class="grid-6">
      <?php foreach (($SECTIONS ?? []) as $s): ?>
        <?php if (empty($s['enabled'])) continue; ?>

        <a
          href="<?= e((string)($s['url'] ?? '')) ?>"
          class="section-tile"
          style="--section-colour: <?= e((string)($s['colour'] ?? '#7413dc')) ?>;"
        >
          <div class="tile-inner">
            <?php
              echo inline_svg((string)($s['logo'] ?? ''), [
                'class' => 'section-logo',
                'role'  => 'img',
                'aria-label' => (string)($s['name'] ?? 'Section') . ' logo',
              ]);
            ?>

            <span class="section-name"><?= e((string)($s['name'] ?? '')) ?></span>
            <span class="section-age">
              <?= e((string)($s['age'] ?? '')) ?>
              <?php if (!empty($s['kind']) && $s['kind'] !== 'group'): ?>
                <span class="section-kind">· <?= e(ucfirst((string)$s['kind'])) ?></span>
              <?php endif; ?>
            </span>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- What is Scouts? (with image) -->
<section class="section">
  <div class="container">
    <div class="hp-split card">
      <div class="hp-split__content">
        <h2>What is Scouts?</h2>
        <p>
          Scouts helps young people gain skills for life through adventure, teamwork and new experiences outdoors and in the community.
          Every week our members build confidence, try new things and make friends — all while having fun.
        </p>
        <p>
          We welcome young people of all backgrounds and make reasonable adjustments so everyone can take part.
        </p>
      </div>

      <div class="hp-split__media">
        <img
          src="<?= e(asset_url('/assets/img/img5.webp')) ?>"
          alt=""
          loading="lazy"
          decoding="async"
          width="900"
          height="700">
      </div>
    </div>
  </div>
</section>

<!-- Where we meet (with image, uses config venue vars only) -->
<section class="section bg-surface">
  <div class="container">
    <div class="hp-split card hp-split--reverse">
      <div class="hp-split__content">
        <h2>Where we meet</h2>
<p>
  We meet at
  <strong><?= e((string)($SITE['venue']['name'] ?? 'our Scout Centre')) ?></strong><?php
    $area = trim((string)($SITE['venue']['area'] ?? ''));
    if ($area !== '') echo ', serving families across ' . e($area);
  ?>.
</p>
        <p>
          Each section meets weekly during term time. Visit the calendar for the latest meeting times and events.
        </p>

        <p class="homepage-cta">
          <a class="btn secondary" href="/contact.php">Find us & get in touch</a>
        </p>
      </div>

      <div class="hp-split__media">
        <img
          src="<?= e(asset_url('/assets/img/img6.webp')) ?>"
          alt=""
          loading="lazy"
          decoding="async"
          width="900"
          height="700">
      </div>
    </div>
  </div>
</section>

<?php
// Supporters section (static if few, marquee if many)
$supporters = $SUPPORTERS['items'] ?? [];
if (!is_array($supporters)) $supporters = [];

$max = (int)($SUPPORTERS['max'] ?? 0);
if ($max > 0) $supporters = array_slice($supporters, 0, $max);

$count = count($supporters);
$marqueeThreshold = 6; // change if you like
?>

<?php if ($count > 0): ?>
<section class="section">
  <div class="container">
    <h2 class="text-center">Our Supporters</h2>
    <p class="text-center supporters-lead">
      We’re grateful to the organisations and people who help make Scouts in Ashby possible.
    </p>

    <?php if ($count < $marqueeThreshold): ?>
      <!-- Static grid -->
      <div class="supporters">
        <?php foreach ($supporters as $sp): ?>
          <?php
            $name = trim((string)($sp['name'] ?? ''));
            $logo = trim((string)($sp['logo'] ?? ''));
            $url  = trim((string)($sp['url'] ?? ''));
            if ($name === '' || $logo === '') continue;
            $hasLink = $url !== '' && filter_var($url, FILTER_VALIDATE_URL);
          ?>
          <div class="supporter">
            <?php if ($hasLink): ?>
              <a href="<?= e($url) ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= e($name) ?>">
                <img src="<?= e(asset_url($logo)) ?>" alt="<?= e($name) ?>" loading="lazy" decoding="async">
              </a>
            <?php else: ?>
              <img src="<?= e(asset_url($logo)) ?>" alt="<?= e($name) ?>" loading="lazy" decoding="async">
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>

    <?php else: ?>
      <!-- Animated marquee -->
      <div class="supporters-marquee" aria-label="Supporters">
        <div class="supporters-track">
          <?php $loop = array_merge($supporters, $supporters); ?>
          <?php foreach ($loop as $sp): ?>
            <?php
              $name = trim((string)($sp['name'] ?? ''));
              $logo = trim((string)($sp['logo'] ?? ''));
              $url  = trim((string)($sp['url'] ?? ''));
              if ($name === '' || $logo === '') continue;
              $hasLink = $url !== '' && filter_var($url, FILTER_VALIDATE_URL);
            ?>
            <div class="supporter">
              <?php if ($hasLink): ?>
                <a href="<?= e($url) ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= e($name) ?>">
                  <img src="<?= e(asset_url($logo)) ?>" alt="<?= e($name) ?>" loading="lazy" decoding="async">
                </a>
              <?php else: ?>
                <img src="<?= e(asset_url($logo)) ?>" alt="<?= e($name) ?>" loading="lazy" decoding="async">
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

  </div>
</section>
<?php endif; ?>

<!-- Safety & Safeguarding (replicating scouts.org.uk style) -->
<section class="section hp-safety">
  <div class="container">
    <h2 class="hp-safety__title">Safety and safeguarding</h2>

    <p class="hp-safety__intro">
      At <?= e($SITE['name'] ?? 'our Scout Group') ?> we are committed to providing a safe, supportive and inclusive environment
      for all young people. Our volunteers follow the Scouts UK safeguarding policies to protect members and respond to concerns
      promptly and appropriately.
    </p>

    <p class="hp-safety__explain">
		Keeping young people safe is central to everything we do. All our leaders and volunteers are DBS-checked, trained in safeguarding,
  		and follow the official Scouts UK policies and best practices. If you have any concerns about safety or wellbeing, please let us
  		know promptly so we can support you and your family.
	</p>
    
    <p class="hp-safety__note">
      If there is an immediate risk of harm call <strong>999</strong> or <strong>112</strong> straight away.
    </p>

    <div class="hp-safety__grid">
      <div class="hp-safety__col">
        <h3 class="hp-safety__col-title">Reporting a safety incident</h3>
    		<p class="hp-safety__explain">        
        		Safety relates to incidents, injuries or hazards — for guidance and reporting use the links below.
        	</p>
        <ul class="hp-safety__list">
          <li>
            <a href="/contact.php" class="hp-safety__link">
              Contact us to report a safety concern
            </a>
          </li>
          <li>
            <a href="https://www.scouts.org.uk/volunteers/staying-safe-and-safeguarding/safe-scouting-cards/" class="hp-safety__link" target="_blank" rel="noopener noreferrer">
              Safe Scouting cards (UK guidance)
            </a>
          </li>
        </ul>
      </div>

      <div class="hp-safety__col">
        <h3 class="hp-safety__col-title">Reporting a safeguarding concern</h3>
    		<p class="hp-safety__explain">        
        		Safeguarding deals with concerns about a young person’s welfare or protection. If you have a concern, please report it promptly via the official Scouts reporting routes.
        	</p>
        <ul class="hp-safety__list">
          <li>
            <a href="https://www.scouts.org.uk/volunteers/staying-safe-and-safeguarding/reporting-a-concern-to-safeguarding/" class="hp-safety__link" target="_blank" rel="noopener noreferrer">
              How to report a safeguarding concern
            </a>
          </li>
          <li>
            <a href="https://www.scouts.org.uk/volunteers/staying-safe-and-safeguarding/safe-scouting-cards/safeguarding-code-of-conduct-for-adults-yellow-card/" class="hp-safety__link" target="_blank" rel="noopener noreferrer">
              Yellow Card — Safeguarding Code of Conduct
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>