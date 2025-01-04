<?php
session_start();
include('../includes/config.php');
include('../includes/functions.php');
redirectIfNotLoggedIn();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $asset_id = $_POST['asset_id'];
    $assigned_to = $_POST['assigned_to'];
    $issue_description = $_POST['issue_description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $status = $_POST['status'];

    // Generate work_order_id like "WKO2001"
    $currentYear = date('Y');  // Get current year
    $sql = "SELECT MAX(SUBSTRING(work_order_id, 4)) AS max_id FROM work_orders WHERE work_order_id LIKE 'WKO$currentYear%'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $maxId = $row['max_id'];
    $newId = ($maxId === null) ? 1 : $maxId + 1;
    $workOrderId = "WKO$currentYear" . sprintf('%04d', $newId);

    // Insert data into work_orders table
    $sql = "INSERT INTO work_orders (work_order_id, asset_id, assigned_to, issue_description, start_date, end_date, status)
            VALUES ('$workOrderId', '$asset_id', '$assigned_to', '$issue_description', '$start_date', '$end_date', '$status')";

    if ($conn->query($sql) === TRUE) {
        header("Location: manage_work_orders.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Work Order</title>
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
    <h1>Add Work Order</h1>
    <form method="POST" action="add_work_order.php">
      <label for="asset_id">Asset ID:</label>
      <input type="text" id="asset_id" name="asset_id" required>

      <label for="assigned_to">Assigned To:</label>
      <input type="text" id="assigned_to" name="assigned_to" required>

      <label for="issue_description">Issue Description:</label>
      <textarea id="issue_description" name="issue_description" required></textarea>

      <label for="start_date">Start Date:</label>
      <input type="date" id="start_date" name="start_date" required>

      <label for="end_date">End Date:</label>
      <input type="date" id="end_date" name="end_date" required>

      <label for="status">Status:</label>
      <select id="status" name="status" required>
        <option value="pending">Pending</option>
        <option value="in progress">In Progress</option>
        <option value="completed">Completed</option>
        <option value="cancelled">Cancelled</option>
      </select>

      <button type="submit">Add Work Order</button>
    </form>
    <button class="back-button" onclick="window.location.href='manage_work_orders.php'">Go Back</button>
  </div>
</body>
</html>