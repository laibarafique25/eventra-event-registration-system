<?php
require_once 'config.php';
requireAdmin();

$rows = $pdo->query("
    SELECT r.id, u.name AS user_name, u.email AS user_email,
           e.title AS event_title, e.event_date, e.location,
           r.reg_date
    FROM registrations r
    JOIN users u  ON r.user_id  = u.id
    JOIN events e ON r.event_id = e.id
    ORDER BY r.reg_date DESC
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Registrations • Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="assets/admin.css?v=2">
</head>
<body class="admin-body">
<?php include 'sidebar.php'; ?>

<main class="content">
  <header class="topbar">
    <div>
      <h1>View Registrations</h1>
      <p class="muted">Who registered for which event</p>
    </div>
    <div class="badge"><?= count($rows) ?> total</div>
  </header>

  <section class="card">
    <?php if (!$rows): ?>
      <p class="empty">No registrations yet.</p>
    <?php else: ?>
      <table class="data-table">
        <thead>
          <tr>
            <th>#</th><th>User</th><th>Email</th><th>Event</th><th>Event Date</th><th>Location</th><th>Registered</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $i => $r): ?>
            <tr>
              <td><?= $i + 1 ?></td>
              <td><strong><?= e($r['user_name']) ?></strong></td>
              <td><?= e($r['user_email']) ?></td>
              <td><?= e($r['event_title']) ?></td>
              <td><i class="fa-regular fa-calendar"></i> <?= e(date('M d, Y', strtotime($r['event_date']))) ?></td>
              <td><?= e($r['location']) ?></td>
              <td><?= e(date('M d, Y H:i', strtotime($r['reg_date']))) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </section>
</main>
</body>
</html>
