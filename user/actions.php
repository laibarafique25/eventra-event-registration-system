<?php
require_once '../config.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$action = $_POST['action'] ?? '';
$userId = (int)$_SESSION['user_id'];

if ($action === 'register') {
    $eventId = (int)($_POST['event_id'] ?? 0);
    if ($eventId <= 0) {
        header('Location: index.php?msg=Invalid event.');
        exit;
    }

    $check = $pdo->prepare('SELECT id FROM events WHERE id = ?');
    $check->execute([$eventId]);
    if (!$check->fetch()) {
        header('Location: index.php?msg=Event not found.');
        exit;
    }

    $dup = $pdo->prepare('SELECT id FROM registrations WHERE user_id = ? AND event_id = ?');
    $dup->execute([$userId, $eventId]);
    if ($dup->fetch()) {
        header('Location: index.php?msg=You are already registered.');
        exit;
    }

    $ins = $pdo->prepare('INSERT INTO registrations (user_id, event_id) VALUES (?, ?)');
    $ins->execute([$userId, $eventId]);
    header('Location: dashboard.php?msg=Successfully registered!');
    exit;
}

if ($action === 'cancel') {
    $regId = (int)($_POST['reg_id'] ?? 0);
    if ($regId <= 0) {
        header('Location: dashboard.php?msg=Invalid request.');
        exit;
    }
    $del = $pdo->prepare('DELETE FROM registrations WHERE id = ? AND user_id = ?');
    $del->execute([$regId, $userId]);
    header('Location: dashboard.php?msg=Registration cancelled.');
    exit;
}

header('Location: index.php');
exit;
