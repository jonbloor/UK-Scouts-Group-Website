<?php
declare(strict_types=1);
require __DIR__ . '/includes/config.php';
$pageTitle = 'Contact';
require __DIR__ . '/partials/header.php';
?>

<section class="hero">
  <div class="container">
    <h1>Contact</h1>
    <p class="lead">Send a message about joining, volunteering, hire or general enquiries.</p>
  </div>
</section>

<section class="section">
  <div class="container grid-2">
    <div class="card">
      <h2>Send a message</h2>
      <form class="form" method="post" action="/contact-submit.php">
        <label>Your name <input name="name" required></label>
        <label>Email <input type="email" name="email" required></label>
        <label>Topic
          <select name="topic" required>
            <option value="joining">Joining</option>
            <option value="volunteering">Volunteering</option>
            <option value="hire">Scout Centre hire</option>
            <option value="general">General</option>
          </select>
        </label>
        <label>Message <textarea name="message" rows="5" required></textarea></label>
        <button class="btn primary" type="submit">Send</button>
      </form>
      <p class="hint" style="margin-top:0.75rem;">This is a placeholder handler. We can wire this to email + SQLite next.</p>
    </div>

    <div class="card">
      <h2>Email</h2>
      <p><a href="mailto:<?= e($SITE['email']) ?>"><?= e($SITE['email']) ?></a></p>
      <h2 style="margin-top:1.5rem;">Address</h2>
      <p>Not specified</p>
    </div>
  </div>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>