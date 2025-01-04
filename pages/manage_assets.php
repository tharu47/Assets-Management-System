<?php
session_start();
include('../includes/config.php');
include('../includes/functions.php');
redirectIfNotLoggedIn();
?>

<!-- left section -->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Asset Management Dashboard</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="../assets/css/styles.css">
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
        <i class="fas fa-tools"></i>
        <span class="nav-item">Financial</span>
        </a></li>

        <li><a href="../logout.php" class="logout">
          <i class="fas fa-sign-out-alt"></i>
          <span class="nav-item">Log out</span>
        </a></li>
      </ul>
    </nav>

    <!-- Right section -->

    <section class="main">

      <h1>Manage Assets</h1>
      <a href="add_asset.php">Add New Asset</a>
      <table>
        <thead>
          <tr>
            <th>Asset ID</th>
            <th>Category ID</th>
            <th>Name</th>
            <th>Status</th>
            <th>Location</th>
            <th>Assign To</th>
            <th>QR Code</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT a.*, c.category_id, c.category_name 
                  FROM assets a 
                  JOIN categories c ON a.category_id = c.category_id";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $row['asset_id'] . "</td>";
              echo "<td>" . $row['category_id'] . "</td>";
              echo "<td>" . $row['name'] . "</td>";
              echo "<td>" . $row['status'] . "</td>";
              echo "<td>" . $row['location'] . "</td>";
              echo "<td>" . $row['assigned_to'] . "</td>";
              echo "<td><img src='generate_qr.php?id=" . $row['asset_id'] . "' alt='QR Code'></td>";
              echo "<td>
                    <a href='edit_asset.php?id=" . $row['asset_id'] . "'><i class='fas fa-edit'></i> Edit</a> 
                    <a href='delete_asset.php?id=" . $row['asset_id'] . "'><i class='fas fa-trash-alt'></i> Delete</a>
                    </td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='11'>No assets found</td></tr>";
          }

          $conn->close();
          ?>
        </tbody>
      </table>
     
    </section>

  </div>
</body>
</html>
