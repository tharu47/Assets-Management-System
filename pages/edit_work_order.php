<?php
session_start();
include('../includes/config.php');
include('../includes/functions.php');
redirectIfNotLoggedIn();

$work_order = null;

if (isset($_GET['work_order_id'])) {
    $work_order_id = $_GET['work_order_id'];
    
    // Fetch current work order data
    $sql = "SELECT * FROM work_orders WHERE work_order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $work_order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $work_order = $result->fetch_assoc();
    } else {
        echo "Work order not found.";
        exit();
    }
    $stmt->close();
} else {
    echo "No work order ID provided.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $asset_id = $_POST['asset_id'];
    $assigned_to = $_POST['assigned_to'];
    $issue_description = $_POST['issue_description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $status = $_POST['status'];
    $work_order_id = $_POST['work_order_id'];

    // Update data in work_orders table
    $sql = "UPDATE work_orders 
            SET asset_id=?, assigned_to=?, issue_description=?, start_date=?, end_date=?, status=? 
            WHERE work_order_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $asset_id, $assigned_to, $issue_description, $start_date, $end_date, $status, $work_order_id);

    if ($stmt->execute()) {
        header("Location: manage_work_orders.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Work Order</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .container {
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      max-width: 600px;
      width: 100%;
    }
    h1 {
      margin-bottom: 20px;
      font-size: 24px;
      color: #333;
    }
    label {
      display: block;
      margin-bottom: 5px;
      color: #666;
    }
    input[type="text"],
    input[type="date"],
    textarea,
    select {
      width: 95%;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 16px;
    }
    button {
      background-color: #28a745;
      color: #fff;
      padding: 10px 15px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
      width: 95%;
    }
    button:hover {
      background-color: #218838;
    }
    .back-button {
      background-color: #007bff;
      color: #fff;
      padding: 10px 15px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
      margin-top: 10px;
      width: 95%;
    }
    .back-button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Edit Work Order</h1>
    <?php if ($work_order): ?>
    <form method="POST" action="edit_work_order.php">
      <input type="hidden" name="work_order_id" value="<?php echo $work_order['work_order_id']; ?>">
      
      <label for="asset_id">Asset ID:</label>
      <input type="text" id="asset_id" name="asset_id" value="<?php echo htmlspecialchars($work_order['asset_id']); ?>" required>

      <label for="assigned_to">Assigned To:</label>
      <input type="text" id="assigned_to" name="assigned_to" value="<?php echo htmlspecialchars($work_order['assigned_to']); ?>" required>

      <label for="issue_description">Issue Description:</label>
      <textarea id="issue_description" name="issue_description" required><?php echo htmlspecialchars($work_order['issue_description']); ?></textarea>

      <label for="start_date">Start Date:</label>
      <input type="date" id="start_date" name="start_date" value="<?php echo $work_order['start_date']; ?>" required>

      <label for="end_date">End Date:</label>
      <input type="date" id="end_date" name="end_date" value="<?php echo $work_order['end_date']; ?>" required>

      <label for="status">Status:</label>
      <select id="status" name="status" required>
        <option value="pending" <?php if ($work_order['status'] == 'pending') echo 'selected'; ?>>Pending</option>
        <option value="in progress" <?php if ($work_order['status'] == 'in progress') echo 'selected'; ?>>In Progress</option>
        <option value="completed" <?php if ($work_order['status'] == 'completed') echo 'selected'; ?>>Completed</option>
        <option value="cancelled" <?php if ($work_order['status'] == 'cancelled') echo 'selected'; ?>>Cancelled</option>
      </select>

      <button type="submit">Update Work Order</button>
    </form>
    <?php else: ?>
    <p>Work order data could not be found.</p>
    <?php endif; ?>
    <button class="back-button" onclick="window.location.href='manage_work_orders.php'">Go Back</button>
  </div>
</body>
</html>