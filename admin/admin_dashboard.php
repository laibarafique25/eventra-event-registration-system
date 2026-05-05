<?php
require_once 'config.php';
requireAdmin();

$totalEvents = $pdo->query("SELECT COUNT(*) FROM events")->fetchColumn();
$totalUsers  = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalRegs   = $pdo->query("SELECT COUNT(*) FROM registrations")->fetchColumn();

$recent = $pdo->query("
    SELECT r.id, u.name AS user_name, u.email, e.title AS event_title, r.reg_date
    FROM registrations r
    JOIN users u  ON r.user_id  = u.id
    JOIN events e ON r.event_id = e.id
    ORDER BY r.reg_date DESC
    LIMIT 5
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard • Admin</title>
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
      <h1>Dashboard</h1>
      <p class="muted">Overview of your event platform</p>
    </div>
  </header>

  <section class="stats-grid">
    <div class="stat-card">
      <div class="stat-icon indigo"><i class="fa-solid fa-calendar-days"></i></div>
      <div>
        <div class="stat-label">Total Events</div>
        <div class="stat-value"><?= (int)$totalEvents ?></div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon emerald"><i class="fa-solid fa-users"></i></div>
      <div>
        <div class="stat-label">Total Users</div>
        <div class="stat-value"><?= (int)$totalUsers ?></div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon amber"><i class="fa-solid fa-ticket"></i></div>
      <div>
        <div class="stat-label">Total Registrations</div>
        <div class="stat-value"><?= (int)$totalRegs ?></div>
      </div>
    </div>
  </section>

  <section class="card">
    <div class="card-header">
      <h2><i class="fa-solid fa-clock-rotate-left"></i> Recent Registrations</h2>
      <a href="admin_registrations.php" class="link">View all →</a>
    </div>

    <?php if (!$recent): ?>
      <p class="empty">No registrations yet.</p>
    <?php else: ?>
      <table class="data-table">
        <thead>
          <tr><th>User</th><th>Email</th><th>Event</th><th>Date</th></tr>
        </thead>
        <tbody>
          <?php foreach ($recent as $r): ?>
            <tr>
              <td><?= e($r['user_name']) ?></td>
              <td><?= e($r['email']) ?></td>
              <td><?= e($r['event_title']) ?></td>
              <td><?= e(date('M d, Y', strtotime($r['reg_date']))) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </section>
</main>
</body>
</html>
