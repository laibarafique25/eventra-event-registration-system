<?php
require_once 'config.php';
requireAdmin();

$action = $_POST['action'] ?? '';

try {
    switch ($action) {
        case 'add_event': {
            $title       = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $event_date  = trim($_POST['event_date'] ?? '');
            $location    = trim($_POST['location'] ?? '');
            $image_url   = trim($_POST['image_url'] ?? '');

            if ($title === '' || $description === '' || $event_date === '' || $location === '') {
                flash('error', 'Please fill all required fields.');
                header("Location: admin_events.php"); exit;
            }

            $stmt = $pdo->prepare("
                INSERT INTO events (title, description, event_date, location, image_url)
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->execute([$title, $description, $event_date, $location, $image_url ?: null]);
            flash('success', 'Event added successfully.');
            header("Location: admin_events.php"); exit;
        }

        case 'update_event': {
            $id          = (int)($_POST['id'] ?? 0);
            $title       = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $event_date  = trim($_POST['event_date'] ?? '');
            $location    = trim($_POST['location'] ?? '');
            $image_url   = trim($_POST['image_url'] ?? '');

            if ($id <= 0 || $title === '' || $description === '' || $event_date === '' || $location === '') {
                flash('error', 'Invalid update data.');
                header("Location: admin_events.php"); exit;
            }

            $stmt = $pdo->prepare("
                UPDATE events
                SET title = ?, description = ?, event_date = ?, location = ?, image_url = ?
                WHERE id = ?
            ");
            $stmt->execute([$title, $description, $event_date, $location, $image_url ?: null, $id]);
            flash('success', 'Event updated successfully.');
            header("Location: admin_events.php"); exit;
        }

        case 'delete_event': {
            $id = (int)($_POST['id'] ?? 0);
            if ($id <= 0) {
                flash('error', 'Invalid event id.');
                header("Location: admin_events.php"); exit;
            }
            $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
            $stmt->execute([$id]);
            flash('success', 'Event deleted successfully.');
            header("Location: admin_events.php"); exit;
        }

        default:
            flash('error', 'Unknown action.');
            header("Location: admin_dashboard.php"); exit;
    }
} catch (Exception $ex) {
    flash('error', 'Error: ' . $ex->getMessage());
    header("Location: admin_events.php"); exit;
}
