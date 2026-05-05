<?php
$current = basename($_SERVER['PHP_SELF']);
function navActive($file) {
    global $current;
    return $current === $file ? 'active' : '';
}
?>
<a href="#admin-sidebar" class="sidebar-open-btn" aria-label="Open menu"><i class="fa-solid fa-bars"></i></a>
<aside id="admin-sidebar" class="sidebar">
  <a href="#" class="sidebar-close"><i class="fa-solid fa-xmark"></i> Close menu</a>
  <div class="sidebar-brand">
    <div class="brand-icon"><i class="fa-solid fa-calendar-check"></i></div>
    <div>
      <div class="brand-name">◆ Eventra</div>
      <div class="brand-sub">Admin Panel</div>
    </div>
  </div>

  <nav class="sidebar-nav">
    <a href="admin_dashboard.php" class="<?= navActive('admin_dashboard.php') ?>">
      <i class="fa-solid fa-gauge-high"></i> Dashboard
    </a>
    <a href="admin_events.php" class="<?= navActive('admin_events.php') ?>">
      <i class="fa-solid fa-calendar-days"></i> Manage Events
    </a>
    <a href="admin_registrations.php" class="<?= navActive('admin_registrations.php') ?>">
      <i class="fa-solid fa-users"></i> View Registrations
    </a>
  </nav>

  <div class="sidebar-footer">
    <div class="admin-chip">
      <div class="avatar"><?= strtoupper(substr($_SESSION['admin_name'] ?? 'A', 0, 1)) ?></div>
      <div>
        <div class="who"><?= e($_SESSION['admin_name'] ?? 'Admin') ?></div>
        <div class="who-sub"><?= e($_SESSION['admin_email'] ?? '') ?></div>
      </div>
    </div>
    <a href="admin_logout.php" class="logout-link"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
  </div>
</aside>
<a href="#" class="sidebar-backdrop" aria-label="Close menu"></a>
