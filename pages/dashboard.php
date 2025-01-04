<?php
session_start();
include('../includes/config.php');
include('../includes/functions.php');
redirectIfNotLoggedIn();

$notifications = isset($_SESSION['notifications']) ? $_SESSION['notifications'] : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Asset Management Dashboard</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
</head>
<body>
  <div class="container">
    <nav>
      <ul>
        <li><a href="dashboard.php" class="logo">
          <img src="../assets/images/logo.png" alt="BCI Logo">
        </a></li>
        <li><a href="dashboard.php">
          <i class="fas fa-home"></i>
          <span class="nav-item">Home</span>
        </a></li>

        <li><a href="manage_users.php">
          <i class="fas fa-users"></i>
          <span class="nav-item">Users</span>
        </a></li>

        <li><a href="manage_assets.php">
        <i class="fas fa-network-wired"></i>
          <span class="nav-item">Assets</span>
        </a></li>
         <li><a href="manage_categories.php">
          <i class="fas fa-layer-group"></i>
          <span class="nav-item">Category</span>
        </a></li>

        <li><a href="manage_maintenance.php">
          <i class="fas fa-users"></i>
          <span class="nav-item">Maintenance</span>
        </a></li>

        <li><a href="manage_work_orders.php">
        <i class="fas fa-tools"></i>
        <span class="nav-item">Work Order</span>
        </a></li>

        <li><a href="manage_financial.php">
        <i class="fas fa-receipt"></i>
        <span class="nav-item">Financial</span>
        </a></li>

        <li><a href="../logout.php" class="logout">
          <i class="fas fa-sign-out-alt"></i>
          <span class="nav-item">Log out</span>
        </a></li>
      </ul>
    </nav>

    <!-- main section -->

    <section class="main">
      <div class="header">
        <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>
        <div class="notification-icon">
          <i class="fas fa-bell"></i>
          <span class="notification-count"><?php echo count($notifications); ?></span>
        </div>
      </div>
      <div class="main-top">
        <h1>Assets Management System</h1>
      </div>
      <div class="main-services">
        <div class="card">
          <i class="fas fa-network-wired"></i>
          <h3>Total Assets</h3>
          <p>Manage Total Assets</p>
          <a href="manage_assets.php">Manage Assets</a>
        </div>
        <div class="card">
          <i class="fas fa-layer-group"></i>
          <h3>Category</h3>
          <p>Manage Assets Categories</p>
          <a href="manage_categories.php">View Category</a>
        </div>
        <div class="card">
          <i class="fas fa-tools"></i>
          <h3>Work Order</h3>
          <p>Manage and assign Work Order</p>
          <a href="manage_categories.php">View Work Order</a>
        </div>
        <div class="card">
          <i class="fas fa-receipt"></i>
          <h3>Reports</h3>
          <p>Generate and analyze service reports.</p>
          <a href="reports.php">View Reports</a>
        </div>
      </div>
      <section class="main-appointments">
      </section>
      <div class="notification-panel">
        <h2>Notifications</h2>
        <ul>
          <?php foreach ($notifications as $notification) : ?>
            <li><?php echo $notification; ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </section>
  </div>
</body>
</html>