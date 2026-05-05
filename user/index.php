<?php
require_once '../config.php';

$stmt = $pdo->query('SELECT * FROM events ORDER BY event_date ASC');
$events = $stmt->fetchAll();

$registeredIds = [];
if (isLoggedIn()) {
    $s = $pdo->prepare('SELECT event_id FROM registrations WHERE user_id = ?');
    $s->execute([$_SESSION['user_id']]);
    $registeredIds = array_column($s->fetchAll(), 'event_id');
}

$flash = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Eventra — Discover Events</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<nav class="navbar glass">
  <a href="index.php" class="brand">◆ Eventra</a>
  <div class="nav-links">
    <a href="index.php" class="active">Events</a>
    <?php if (isLoggedIn()): ?>
      <a href="dashboard.php">My Events</a>
      <span class="hello">Hi, <?= e($_SESSION['user_name']) ?></span>
      <a href="auth.php?action=logout" class="btn btn-ghost">Logout</a>
    <?php else: ?>
      <a href="auth.php?mode=login" class="btn btn-ghost">Login</a>
      <a href="auth.php?mode=signup" class="btn btn-primary">Sign Up</a>
    <?php endif; ?>
  </div>
</nav>

<header class="hero">
  <span class="eyebrow">Curated • Premium • Live</span>
  <h1>Discover Events</h1>
  <p>Hand-picked conferences, workshops, and meetups crafted for ambitious minds.</p>
</header>

<?php if ($flash): ?>
  <div class="container"><div class="alert info"><?= e($flash) ?></div></div>
<?php endif; ?>

<section class="container">
  <div class="grid">
    <?php foreach ($events as $ev): ?>
      <?php $isReg = in_array((int)$ev['id'], array_map('intval', $registeredIds), true); ?>
      <article class="card">
        <div class="card-img" style="background-image:url('<?= e($ev['image_url'] ?: 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=800') ?>')"></div>
        <div class="card-body">
          <div class="card-meta">
            <span class="pill"><?= e(date('M d, Y', strtotime($ev['event_date']))) ?></span>
            <span class="pill subtle"><?= e($ev['location']) ?></span>
          </div>
          <h3><?= e($ev['title']) ?></h3>
          <p><?= e($ev['description']) ?></p>
          <?php if ($isReg): ?>
            <button class="btn btn-success" disabled>✓ Registered</button>
          <?php elseif (isLoggedIn()): ?>
            <form method="POST" action="actions.php">
              <input type="hidden" name="action" value="register">
              <input type="hidden" name="event_id" value="<?= (int)$ev['id'] ?>">
              <button type="submit" class="btn btn-primary">Register Now</button>
            </form>
          <?php else: ?>
            <a href="auth.php?mode=login" class="btn btn-primary">Register Now</a>
          <?php endif; ?>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
</section>

<footer class="footer">© <?= date('Y') ?> Eventra — Built for CodeAlpha Internship</footer>
</body>
</html>
