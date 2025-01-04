<?php
session_start();
include('../includes/config.php');
include('../includes/functions.php');
redirectIfNotLoggedIn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Financial Management Dashboard</title>
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

    <!-- main section -->
    <section class="main">
      <h1>Manage Financial Records</h1>
      <a href="add_financial.php">Add New Financial Record</a>
      <table>
        <thead>
          <tr>
            <th>Record ID</th>
            <th>Asset ID</th>
            <th>Transaction Date</th>
            <th>Amount</th>
            <th>Type</th>
            <th>Description</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Database connection is established via config.php
          $sql = "SELECT fr.*, a.name as asset_name 
                  FROM financial_records fr 
                  JOIN assets a ON fr.asset_id = a.asset_id";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $row['record_id'] . "</td>";
              echo "<td>" . $row['asset_id'] . " (" . $row['asset_name'] . ")</td>";
              echo "<td>" . $row['transaction_date'] . "</td>";
              echo "<td>" . $row['amount'] . "</td>";
              echo "<td>" . $row['type'] . "</td>";
              echo "<td>" . $row['description'] . "</td>";
              echo "<td>
                    <a href='edit_financial.php?id=" . $row['record_id'] . "'><i class='fas fa-edit'></i> Edit</a> 
                    <a href='delete_financial.php?id=" . $row['record_id'] . "'><i class='fas fa-trash-alt'></i> Delete</a>
                    </td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='7'>No financial records found</td></tr>";
          }

          // Close the database connection
          $conn->close();
          ?>
        </tbody>
      </table>
    </section>
  </div>
</body>
</html>
