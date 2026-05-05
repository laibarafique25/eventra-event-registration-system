<?php
require_once '../config.php';

$mode = $_GET['mode'] ?? 'login';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'signup') {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($name === '' || $email === '' || $password === '') {
            $error = 'All fields are required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please enter a valid email.';
        } elseif (strlen($password) < 6) {
            $error = 'Password must be at least 6 characters.';
        } else {
            try {
                $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
                $stmt->execute([$email]);
                if ($stmt->fetch()) {
                    $error = 'Email is already registered.';
                } else {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
                    $stmt->execute([$name, $email, $hash]);
                    $_SESSION['user_id'] = (int)$pdo->lastInsertId();
                    $_SESSION['user_name'] = $name;
                    header('Location: index.php');
                    exit;
                }
            } catch (PDOException $ex) {
                $error = 'Something went wrong. Please try again.';
            }
        }
        $mode = 'signup';
    } elseif ($action === 'login') {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            $error = 'Email and password are required.';
        } else {
            $stmt = $pdo->prepare('SELECT id, name, password FROM users WHERE email = ?');
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = (int)$user['id'];
                $_SESSION['user_name'] = $user['name'];
                header('Location: index.php');
                exit;
            }
            $error = 'Invalid email or password.';
        }
        $mode = 'login';
    } elseif ($action === 'logout') {
        session_destroy();
        header('Location: index.php');
        exit;
    }
}

if (($_GET['action'] ?? '') === 'logout') {
    session_destroy();
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= $mode === 'signup' ? 'Sign Up' : 'Login' ?> — CodeAlpha Events</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body class="auth-body">
<nav class="navbar glass">
  <a href="index.php" class="brand">◆ Eventra</a>
  <div class="nav-links">
    <a href="index.php">Events</a>
  </div>
</nav>

<main class="auth-wrap">
  <div class="auth-card glass-card">
    <h1 class="auth-title"><?= $mode === 'signup' ? 'Create your account' : 'Welcome back' ?></h1>
    <p class="auth-sub"><?= $mode === 'signup' ? 'Join thousands discovering events.' : 'Login to register for events.' ?></p>

    <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>

    <?php if ($mode === 'signup'): ?>
    <form method="POST" class="form">
      <input type="hidden" name="action" value="signup">
      <label>Full name<input type="text" name="name" required></label>
      <label>Email<input type="email" name="email" required></label>
      <label>Password<input type="password" name="password" minlength="6" required></label>
      <button type="submit" class="btn btn-primary">Create Account</button>
      <p class="alt">Already have an account? <a href="auth.php?mode=login">Login</a></p>
    </form>
    <?php else: ?>
    <form method="POST" class="form">
      <input type="hidden" name="action" value="login">
      <label>Email<input type="email" name="email" required></label>
      <label>Password<input type="password" name="password" required></label>
      <button type="submit" class="btn btn-primary">Login</button>
      <p class="alt">New here? <a href="auth.php?mode=signup">Create an account</a></p>
    </form>
    <?php endif; ?>
  </div>
</main>
</body>
</html>
