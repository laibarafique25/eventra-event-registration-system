<?php
require_once '../config.php';
requireLogin();

$stmt = $pdo->prepare('
  SELECT e.*, r.id AS reg_id, r.reg_date
  FROM registrations r
  JOIN events e ON e.id = r.event_id
  WHERE r.user_id = ?
  ORDER BY e.event_date ASC
');
$stmt->execute([$_SESSION['user_id']]);
$myEvents = $stmt->fetchAll();
$flash = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>My Events — Eventra</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<nav class="navbar glass">
  <a href="index.php" class="brand">◆ Eventra</a>
  <div class="nav-links">
    <a href="index.php">Events</a>
    <a href="dashboard.php" class="active">My Events</a>
    <span class="hello">Hi, <?= e($_SESSION['user_name']) ?></span>
    <a href="auth.php?action=logout" class="btn btn-ghost">Logout</a>
  </div>
</nav>

<header class="hero small">
  <span class="eyebrow">Dashboard</span>
  <h1>My Events</h1>
  <p>Events you've registered for.</p>
</header>

<?php if ($flash): ?>
  <div class="container"><div class="alert info"><?= e($flash) ?></div></div>
<?php endif; ?>

<section class="container">
  <?php if (empty($myEvents)): ?>
    <div class="empty glass-card">
      <h3>No registrations yet</h3>
      <p>Browse events and join the ones you love.</p>
      <a href="index.php" class="btn btn-primary">Discover Events</a>
    </div>
  <?php else: ?>
    <div class="grid">
      <?php foreach ($myEvents as $ev): ?>
        <article class="card">
          <div class="card-img" style="background-image:url('<?= e($ev['image_url'] ?: 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=800') ?>')"></div>
          <div class="card-body">
            <div class="card-meta">
              <span class="pill"><?= e(date('M d, Y', strtotime($ev['event_date']))) ?></span>
              <span class="pill subtle"><?= e($ev['location']) ?></span>
            </div>
            <h3><?= e($ev['title']) ?></h3>
            <p><?= e($ev['description']) ?></p>
            <form method="POST" action="actions.php" onsubmit="return confirm('Cancel this registration?');">
              <input type="hidden" name="action" value="cancel">
              <input type="hidden" name="reg_id" value="<?= (int)$ev['reg_id'] ?>">
              <button type="submit" class="btn btn-danger">Cancel Registration</button>
            </form>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>

<footer class="footer">© <?= date('Y') ?> Eventra</footer>
</body>
</html>
