<?php
declare(strict_types=1);
session_start();
require __DIR__ . '/includes/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo 'Method Not Allowed';
  exit;
}

$token = (string)($_POST['csrf_token'] ?? '');
if ($token === '' || !validate_csrf_token($token)) {
  http_response_code(400);
  $pageTitle = 'Contact';
  $pageDesc = 'Contact form error';
  require __DIR__ . '/partials/header.php';
  echo '<section class="section"><div class="container">';
  echo '<h1>Something went wrong</h1>';
  echo '<p>Please go back and try submitting the form again.</p>';
  echo '</div></section>';
  require __DIR__ . '/partials/footer.php';
  exit;
}

$name = trim((string)($_POST['name'] ?? ''));
$email = trim((string)($_POST['email'] ?? ''));
$topic = trim((string)($_POST['topic'] ?? 'general'));
$message = trim((string)($_POST['message'] ?? ''));

$errors = [];
if ($name === '') {
  $errors[] = 'Please enter your name.';
}
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $errors[] = 'Please enter a valid email address.';
}
if ($message === '') {
  $errors[] = 'Please enter a message.';
}

$pageTitle = 'Contact';
$pageDesc = 'Contact form submission';
require __DIR__ . '/partials/header.php';
?>

<section class="section">
  <div class="container">
    <?php if ($errors): ?>
      <h1>We could not send your message</h1>
      <ul>
        <?php foreach ($errors as $error): ?>
          <li><?= e($error) ?></li>
        <?php endforeach; ?>
      </ul>
      <p><a class="btn secondary" href="/contact.php">Go back</a></p>
    <?php else: ?>
      <h1>Thanks for getting in touch</h1>
      <p>We have received your message about <?= e($topic) ?> and will reply to <?= e($email) ?> soon.</p>
      <p><strong>Name:</strong> <?= e($name) ?></p>
      <p><strong>Message:</strong> <?= nl2br(e($message)) ?></p>
      <p><a class="btn primary" href="/index.php">Return home</a></p>
    <?php endif; ?>
  </div>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>
