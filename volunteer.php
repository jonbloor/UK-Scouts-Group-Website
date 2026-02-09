<?php
declare(strict_types=1);
require __DIR__ . '/includes/config.php';
$pageTitle = 'Volunteering';
require __DIR__ . '/partials/header.php';
?>

<section class="hero">
  <div class="container">
    <h1>Volunteering</h1>
    <p class="lead">Support Scouting locally: weekly roles, occasional help, sponsorship and donations.</p>
    <p style="display:flex; gap:0.75rem; flex-wrap:wrap; margin-top:1rem;">
      <a class="btn primary" href="<?= e($CTA['volunteer_url']) ?>">See volunteering roles</a>
      <a class="btn" href="/contact.php">Offer sponsorship or donate</a>
    </p>
  </div>
</section>

<section class="section">
  <div class="container grid-3">
    <div class="card">
      <h3>Weekly help</h3>
      <p>Become part of a section team. Training and support provided.</p>
    </div>
    <div class="card">
      <h3>Occasional help</h3>
      <p>Skills sessions, driving, admin, fundraising, events and maintenance.</p>
    </div>
    <div class="card">
      <h3>Sponsorship and donations</h3>
      <p>Help fund equipment and activities for young people.</p>
    </div>
  </div>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>