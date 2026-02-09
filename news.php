<?php
declare(strict_types=1);
require __DIR__ . '/includes/config.php';
$pageTitle = 'News';
require __DIR__ . '/partials/header.php';
?>

<section class="hero">
  <div class="container">
    <h1>News</h1>
    <p class="lead">Placeholder news index. Later we can store posts in SQLite.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="event">
      <div class="event-title">Placeholder post title</div>
      <div class="event-meta">Date, section tag</div>
      <div>Short excerpt goes here.</div>
    </div>
  </div>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>