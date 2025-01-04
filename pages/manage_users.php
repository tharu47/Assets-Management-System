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

    <!-- main section -->

    <section class="main">

    <h1>Manage Users</h1>
<a href="add_user.php">Add New User</a>
<table>
    <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['role'] . "</td>";
                echo "<td>
                    <a href='edit_user.php?id=" . $row['user_id'] . "'><i class='fas fa-edit'></i> Edit</a> 
                    <a href='delete_user.php?id=" . $row['user_id'] . "'><i class='fas fa-trash-alt'></i> Delete</a>
                    </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No users found</td></tr>";
        }

        $conn->close();
        ?>
    </tbody>
</table>
     
    </section>

  </div>
</body>
</html>
