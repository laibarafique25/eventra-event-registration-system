<?php
require_once 'config.php';
requireAdmin();

$editEvent = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
    $stmt->execute([(int)$_GET['edit']]);
    $editEvent = $stmt->fetch();
}

$events = $pdo->query("SELECT * FROM events ORDER BY event_date DESC")->fetchAll();
$success = flash('success');
$error   = flash('error');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Events • Admin</title>
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
      <h1>Manage Events</h1>
      <p class="muted">Add, edit, or remove events</p>
    </div>
  </header>

  <?php if ($success): ?><div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> <?= e($success) ?></div><?php endif; ?>
  <?php if ($error):   ?><div class="alert alert-error"><i class="fa-solid fa-circle-exclamation"></i> <?= e($error) ?></div><?php endif; ?>

  <section class="card">
    <div class="card-header">
      <h2><i class="fa-solid fa-<?= $editEvent ? 'pen-to-square' : 'plus' ?>"></i>
        <?= $editEvent ? 'Edit Event' : 'Add New Event' ?>
      </h2>
      <?php if ($editEvent): ?><a href="admin_events.php" class="link">+ New instead</a><?php endif; ?>
    </div>

    <form method="POST" action="process_admin.php" class="form-grid">
      <input type="hidden" name="action" value="<?= $editEvent ? 'update_event' : 'add_event' ?>">
      <?php if ($editEvent): ?>
        <input type="hidden" name="id" value="<?= (int)$editEvent['id'] ?>">
      <?php endif; ?>

      <div class="field col-2">
        <label>Title</label>
        <input type="text" name="title" required value="<?= e($editEvent['title'] ?? '') ?>">
      </div>
      <div class="field">
        <label>Date</label>
        <input type="date" name="event_date" required value="<?= e($editEvent['event_date'] ?? '') ?>">
      </div>
      <div class="field">
        <label>Location</label>
        <input type="text" name="location" required value="<?= e($editEvent['location'] ?? '') ?>">
      </div>
      <div class="field col-2">
        <label>Image URL (Unsplash)</label>
        <input type="url" name="image_url" placeholder="https://images.unsplash.com/..." value="<?= e($editEvent['image_url'] ?? '') ?>">
      </div>
      <div class="field col-2">
        <label>Description</label>
        <textarea name="description" rows="4" required><?= e($editEvent['description'] ?? '') ?></textarea>
      </div>
      <div class="field col-2">
        <button type="submit" class="btn-primary">
          <i class="fa-solid fa-<?= $editEvent ? 'floppy-disk' : 'plus' ?>"></i>
          <?= $editEvent ? 'Update Event' : 'Add Event' ?>
        </button>
      </div>
    </form>
  </section>

  <section class="card">
    <div class="card-header">
      <h2><i class="fa-solid fa-list"></i> All Events (<?= count($events) ?>)</h2>
    </div>

    <?php if (!$events): ?>
      <p class="empty">No events yet. Add your first event above.</p>
    <?php else: ?>
      <table class="data-table">
        <thead>
          <tr>
            <th>Image</th><th>Title</th><th>Date</th><th>Location</th><th class="right">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($events as $ev): ?>
            <tr>
              <td>
                <?php if (!empty($ev['image_url'])): ?>
                  <img src="<?= e($ev['image_url']) ?>" alt="" class="thumb">
                <?php else: ?>
                  <div class="thumb thumb-placeholder"><i class="fa-solid fa-image"></i></div>
                <?php endif; ?>
              </td>
              <td><strong><?= e($ev['title']) ?></strong></td>
              <td><i class="fa-regular fa-calendar"></i> <?= e(date('M d, Y', strtotime($ev['event_date']))) ?></td>
              <td><?= e($ev['location']) ?></td>
              <td class="right">
                <a href="admin_events.php?edit=<?= (int)$ev['id'] ?>" class="btn-icon edit" title="Edit">
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <form method="POST" action="process_admin.php" style="display:inline" onsubmit="return confirm('Delete this event? This will also delete all its registrations.');">
                  <input type="hidden" name="action" value="delete_event">
                  <input type="hidden" name="id" value="<?= (int)$ev['id'] ?>">
                  <button type="submit" class="btn-icon delete" title="Delete">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </section>
</main>
</body>
</html>
