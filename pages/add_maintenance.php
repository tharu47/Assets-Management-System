<?php
session_start();
include('../includes/config.php');
include('../includes/functions.php');
redirectIfNotLoggedIn();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the last inserted maintenance ID
    $result = $conn->query("SELECT maintenance_id FROM maintenance ORDER BY maintenance_id DESC LIMIT 1");
    $last_id = $result->fetch_assoc()['maintenance_id'];

    // Extract the numeric part and increment it
    $numeric_part = (int) substr($last_id, 3);
    $new_id = 'MNT' . str_pad($numeric_part + 1, 4, '0', STR_PAD_LEFT);

    $asset_id = $_POST['asset_id'];
    $maintenance_date = $_POST['maintenance_date'];
    $maintenance_type = $_POST['maintenance_type'];
    $description = $_POST['description'];
    $cost = $_POST['cost'];
    $status = $_POST['status'];

    $sql = "INSERT INTO maintenance (maintenance_id, asset_id, maintenance_date, maintenance_type, description, cost, status)
            VALUES ('$new_id', '$asset_id', '$maintenance_date', '$maintenance_type', '$description', '$cost', '$status')";

    if ($conn->query($sql) === TRUE) {
        header("Location: manage_maintenance.php");
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
    <title>Add Maintenance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            color: #555;
        }
        input, select, textarea, button {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            width: 95%;
        }
        button {
            background-color: #28a745;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .back-button {
            background-color: #007bff;
            margin-top: -10px;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add Maintenance Record</h1>
        <form method="POST" action="add_maintenance.php">
            <label for="asset_id">Asset ID:</label>
            <input type="text" id="asset_id" name="asset_id" required>

            <label for="maintenance_date">Maintenance Date:</label>
            <input type="date" id="maintenance_date" name="maintenance_date" required>

            <label for="maintenance_type">Maintenance Type:</label>
            <input type="text" id="maintenance_type" name="maintenance_type" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="cost">Cost:</label>
            <input type="number" step="0.01" id="cost" name="cost" required>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="scheduled">Scheduled</option>
                <option value="in progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>

            <button type="submit">Add Maintenance</button>
        </form>
        <form action="manage_maintenance.php">
            <button type="submit" class="back-button">Go Back</button>
        </form>
    </div>
</body>
</html>