<?php
session_start();
include('../includes/config.php');
include('../includes/functions.php');
redirectIfNotLoggedIn();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $asset_id = $_POST['asset_id'];
    $amount = $_POST['amount'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $transaction_date = $_POST['transaction_date'];

    // Fetch the last inserted record_id
    $result = $conn->query("SELECT record_id FROM financial_records ORDER BY record_id DESC LIMIT 1");
    $lastId = $result->fetch_assoc();

    // Generate new record_id
    if ($lastId) {
        $lastIdNum = (int)substr($lastId['record_id'], 3);
        $newIdNum = $lastIdNum + 1;
    } else {
        $newIdNum = 2001; // Starting number if no records exist
    }
    $record_id = 'FNC' . $newIdNum;

    $sql = "INSERT INTO financial_records (record_id, asset_id, transaction_date, amount, type, description)
            VALUES ('$record_id', '$asset_id', '$transaction_date', '$amount', '$type', '$description')";

    if ($conn->query($sql) === TRUE) {
        header("Location: manage_financial.php");
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
  <title>Add Financial Record</title>
 
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .container {
      background-color: #ffffff;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 20px;
      max-width: 500px;
      width: 100%;
    }
    h1 {
      font-size: 24px;
      color: #343a40;
      text-align: center;
      margin-bottom: 20px;
    }
    form {
      display: flex;
      flex-direction: column;
    }
    label {
      font-size: 16px;
      color: #495057;
      margin-bottom: 5px;
    }
    input, textarea, select {
      padding: 10px;
      border: 1px solid #ced4da;
      border-radius: 5px;
      margin-bottom: 15px;
    }
    button {
      padding: 10px;
      background-color: #007bff;
      border: none;
      border-radius: 5px;
      color: #ffffff;
      font-size: 16px;
      cursor: pointer;
    }
    button:hover {
      background-color: #0056b3;
    }
    .back-button {
      margin-top: 10px;
      padding: 10px;
      background-color: #6c757d;
      border: none;
      border-radius: 5px;
      color: #ffffff;
      font-size: 16px;
      cursor: pointer;
    }
    .back-button:hover {
      background-color: #5a6268;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Add Financial Record</h1>
    <form method="POST" action="add_financial.php">
      <label for="asset_id">Asset ID:</label>
      <input type="text" id="asset_id" name="asset_id" required>

      <label for="amount">Amount:</label>
      <input type="number" step="0.01" id="amount" name="amount" required>

      <label for="type">Type:</label>
      <select id="type" name="type" required>
        <option value="Purchase">Purchase</option>
        <option value="Maintenance">Maintenance</option>
      </select>

      <label for="description">Description:</label>
      <textarea id="description" name="description" rows="4" required></textarea>

      <label for="transaction_date">Transaction Date:</label>
      <input type="date" id="transaction_date" name="transaction_date" required>

      <button type="submit">Add Financial Record</button>
      <button type="button" class="back-button" onclick="window.location.href='manage_financial.php'">Go Back</button>
    </form>
  </div>
</body>
</html>
