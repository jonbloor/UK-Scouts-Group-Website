<?php
declare(strict_types=1);
require __DIR__ . '/includes/config.php';

$slug = $_GET['slug'] ?? 'squirrels';
$slug = preg_replace('/[^a-z0-9\-]/', '', strtolower((string)$slug));

$map = [
  'squirrels' => ['name' => 'Squirrels', 'age' => '4–5', 'meet' => 'Not specified'],
  'beavers'   => ['name' => 'Beavers', 'age' => '6–8', 'meet' => 'Not specified'],
  'cubs'      => ['name' => 'Cubs', 'age' => '8–10½', 'meet' => 'Not specified'],
  'scouts'    => ['name' => 'Scouts', 'age' => '10½–14', 'meet' => 'Not specified'],
  'explorers' => ['name' => 'Explorers', 'age' => '14–18', 'meet' => 'Not specified'],
  'sas'       => ['name' => 'Scout Active Support', 'age' => 'Adults', 'meet' => 'Not specified'],
];

$section = $map[$slug] ?? $map['squirrels'];

$pageTitle = $section['name'];
require __DIR__ . '/partials/header.php';
?>

<section class="hero">
  <div class="container">
    <h1><?= e($section['name']) ?></h1>
    <p class="lead"><span class="badge">Age: <?= e($section['age']) ?></span> <span class="badge">Meetings: <?= e($section['meet']) ?></span></p>
    <p style="display:flex; gap:0.75rem; flex-wrap:wrap; margin-top:1rem;">
      <a class="btn primary" href="<?= e($CTA['join_url']) ?>">Join</a>
      <a class="btn" href="/contact.php">Contact us</a>
    </p>
  </div>
</section>

<section class="section">
  <div class="container grid-2">
    <div class="card">
      <h2>What we do</h2>
      <p>Placeholder text. This is where the section summary goes.</p>
    </div>
    <div class="card">
      <h2>Leaders</h2>
      <p>Placeholder list. You can later drive this from SQLite if you want.</p>
      <ul>
        <li>Not specified</li>
      </ul>
    </div>
  </div>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>