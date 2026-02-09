<?php
declare(strict_types=1);
require __DIR__ . '/includes/config.php';
$pageTitle = 'Sections';
require __DIR__ . '/partials/header.php';

$sections = [
  ['slug' => 'squirrels', 'name' => 'Squirrels', 'age' => '4–5'],
  ['slug' => 'beavers',   'name' => 'Beavers',   'age' => '6–8'],
  ['slug' => 'cubs',      'name' => 'Cubs',      'age' => '8–10½'],
  ['slug' => 'scouts',    'name' => 'Scouts',    'age' => '10½–14'],
  ['slug' => 'explorers', 'name' => 'Explorers', 'age' => '14–18'],
  ['slug' => 'sas',       'name' => 'Scout Active Support', 'age' => 'Adults'],
];
?>

<section class="hero">
  <div class="container">
    <h1>Sections</h1>
    <p class="lead">A quick overview of each section.</p>
  </div>
</section>

<section class="section">
  <div class="container grid-3">
    <?php foreach ($sections as $s): ?>
      <div class="card">
        <h3><?= e($s['name']) ?></h3>
        <p><span class="badge">Age: <?= e($s['age']) ?></span></p>
        <p>Placeholder overview text. Replace with the real description later.</p>
        <a class="btn" href="/section.php?slug=<?= e($s['slug']) ?>">View <?= e($s['name']) ?></a>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>