<?php
declare(strict_types=1);
require __DIR__ . '/includes/config.php';
$pageTitle = 'Home';
require __DIR__ . '/partials/header.php';
?>

<section class="hero">
  <div class="container">
    <h1><?= e($SITE['name']) ?></h1>
    <p class="lead"><?= e($SITE['tagline']) ?></p>
    <p style="display:flex; gap:0.75rem; flex-wrap:wrap; margin-top:1rem;">
      <a class="btn primary" href="<?= e($CTA['join_url']) ?>">Join</a>
      <a class="btn secondary" href="<?= e($CTA['volunteer_url']) ?>">Volunteer</a>
    </p>
  </div>
</section>

<section class="section">
  <div class="container grid-3">
    <div class="card">
      <h3>Join</h3>
      <p>Help for parents, choosing the right section and what to expect.</p>
      <a class="btn" href="/join.php">Go to Join</a>
    </div>
    <div class="card">
      <h3>Scout Centre Hire</h3>
      <p>Facilities, rates and a booking request form.</p>
      <a class="btn" href="/dsc.php">View hire info</a>
    </div>
    <div class="card">
      <h3>News</h3>
      <p>What we’ve been up to recently.</p>
      <a class="btn" href="/news.php">Read news</a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>
