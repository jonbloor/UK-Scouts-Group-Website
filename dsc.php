<?php
declare(strict_types=1);
require __DIR__ . '/includes/config.php';

$pageTitle = $HIRE['name'] . ' – Hire';
$pageDesc  = 'Rates, facilities and booking request form.';
require __DIR__ . '/partials/header.php';
?>

<section class="hero">
  <div class="container">
    <h1><?= e($HIRE['name']) ?></h1>
    <p class="lead">Information, rates and a simple booking request form.</p>
  </div>
</section>

<section class="section">
  <div class="container grid-2">
    <div class="card">
      <h2>Rates</h2>
      <p><?= e($HIRE['deposit_note']) ?></p>

      <ul class="rates">
        <?php foreach ($HIRE['rates'] as $rate): ?>
          <li>
            <span><?= e($rate['label']) ?></span>
            <strong>£<?= number_format((float)$rate['price'], 0) ?></strong>
          </li>
        <?php endforeach; ?>
      </ul>

      <p class="hint" style="margin-top:1rem;">Bookings are usually exclusive. Some bookings may be free or discounted at our discretion.</p>
    </div>

    <div class="card">
      <h2>Booking request</h2>
      <form method="post" action="/hire-submit.php" class="form">
        <label>Name <input name="name" required></label>
        <label>Email <input type="email" name="email" required></label>
        <label>Phone <input name="phone" required></label>
        <label>Planned use <input name="use" required></label>
        <label>Arrival <input type="datetime-local" name="arrival" required></label>
        <label>Departure <input type="datetime-local" name="departure" required></label>
        <label>Booking notes / special requirements <textarea name="notes" rows="4"></textarea></label>
        <button type="submit" class="btn primary">Send booking request</button>
      </form>

      <p class="hint" style="margin-top:0.75rem;">This form can be wired to email + SQLite approvals next.</p>
    </div>
  </div>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>