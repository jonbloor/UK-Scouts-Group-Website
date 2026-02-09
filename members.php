<?php
declare(strict_types=1);
require __DIR__ . '/includes/config.php';
$pageTitle = 'Members';
require __DIR__ . '/partials/header.php';
?>

<section class="hero">
  <div class="container">
    <h1>Members</h1>
    <p class="lead">Useful links and consolidated calendars for current families and volunteers.</p>
    <p style="display:flex; gap:0.75rem; flex-wrap:wrap; margin-top:1rem;">
      <a class="btn primary" href="/calendar.php">Members calendar</a>
      <a class="btn" href="https://onlinescoutmanager.co.uk/login.php">Online Scout Manager (OSM) Login</a>
    </p>
  </div>
</section>

<section class="section">
  <div class="container grid-3">
    <div class="card">
      <h3>Group policies</h3>
      <p>Placeholder. Later: link to PDFs or pages.</p>
    </div>
    <div class="card">
      <h3>Uniform and neckers</h3>
      <p>Placeholder. Often managed via OSM, but we can add a simple info page.</p>
    </div>
    <div class="card">
      <h3>Badge stocks</h3>
      <p>Placeholder. Best handled via a simple form and SQLite list.</p>
    </div>
  </div>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>