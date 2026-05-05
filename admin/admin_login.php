<?php
require_once 'config.php';

if (isAdminLoggedIn()) {
    header("Location: admin_dashboard.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = 'Please enter both email and password.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ?");
        $stmt->execute([$email]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['name'];
            $_SESSION['admin_email'] = $admin['email'];
            header("Location: admin_dashboard.php");
            exit;
        } else {
            $error = 'Invalid credentials.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login • CodeAlpha Events</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="assets/admin.css?v=2">
</head>
<body class="auth-body">
  <div class="auth-card">
    <div class="auth-logo">
      <i class="fa-solid fa-shield-halved"></i>
    </div>
    <h1>Admin Panel</h1>
    <p class="auth-sub">Sign in to manage events &amp; registrations</p>

    <?php if ($error): ?>
      <div class="alert alert-error"><i class="fa-solid fa-circle-exclamation"></i> <?= e($error) ?></div>
    <?php endif; ?>

    <form method="POST" class="auth-form">
      <label>Email</label>
      <input type="email" name="email" required placeholder="admin@codealpha.com">
      <label>Password</label>
      <input type="password" name="password" required placeholder="••••••••">
      <button type="submit" class="btn-primary"><i class="fa-solid fa-right-to-bracket"></i> Sign In</button>
    </form>
    <p class="auth-hint">Default: admin@codealpha.com / admin123</p>
  </div>
</body>
</html>
