<?php
declare(strict_types=1);
require __DIR__ . '/includes/config.php';
$pageTitle = 'Join';
require __DIR__ . '/partials/header.php';
?>

<section class="hero">
  <div class="container">
    <h1>Join</h1>
    <p class="lead">Everything parents need, including choosing the right section.</p>
    <p style="display:flex; gap:0.75rem; flex-wrap:wrap; margin-top:1rem;">
      <a class="btn primary" href="<?= e($CTA['join_url']) ?>">Go to joining form</a>
      <a class="btn" href="/sections.php">Explore sections</a>
    </p>
  </div>
</section>

<section class="section">
  <div class="container grid-2">
    <div class="card" id="which-section">
      <h2>Which section should my child join?</h2>
      <p>Most families start here. We’ll keep this guide simple, and you can always ask if you’re unsure.</p>

      <div class="event" style="margin-top:1rem;">
        <div class="event-title">Quick guide</div>
        <div class="event-meta">Squirrels (4–5), Beavers (6–8), Cubs (8–10½), Scouts (10½–14), Explorers (14–18)</div>
      </div>
<details>
  <p class="hint" style="margin-top: 1rem;">Exact moving-up depends on places and birthdays. Complete the joining form and we'll advise on the best fit.</p>
</details>  
    </div>

    <div class="card">
      <h2>What happens next?</h2>
      <ul>
        <li>Complete the joining form</li>
        <li>We confirm the right section and explain waiting lists</li>
        <li>We invite your child to start when a place is available</li>
      </ul>
      <a class="btn primary full" href="<?= e($CTA['join_url']) ?>">Complete the joining form</a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>