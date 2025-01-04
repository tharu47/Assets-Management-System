<?php
session_start();
include('../includes/config.php');
include('../includes/functions.php');
redirectIfNotLoggedIn();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_name = $_POST['category_name'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $purchase_date = $_POST['purchase_date'];
    $warranty_expiry = $_POST['warranty_expiry'];
    $status = $_POST['status'];
    $assigned_to = $_POST['assigned_to'];
    $location = $_POST['location'];
    $cost = $_POST['cost'];

    
    $categories = [
        'Hardware' => "CAT0001",
        'Software' => "CAT0002",
        'Network' => "CAT0003",
        'Cloud' => "CAT0004",
        'Data' => "CAT0005",
        'Infrastructure' => "CAT0006"
    ];

    
    if (!array_key_exists($category_name, $categories)) {
        echo "<p class='error'>Invalid category name.</p>";
        exit;
    }

    $category_id = $categories[$category_name];

    
    $result = $conn->query("SELECT asset_id FROM assets ORDER BY asset_id DESC LIMIT 1");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastAssetId = $row['asset_id'];
        $lastNumber = intval(substr($lastAssetId, 3)); 
        $newNumber = $lastNumber + 1;
    } else {
        $newNumber = 1; 
    }
    $newAssetId = 'AST' . str_pad($newNumber, 4, '0', STR_PAD_LEFT); 

    $sql = "INSERT INTO assets (asset_id, category_id, name, description, purchase_date, warranty_expiry, status, assigned_to, location, cost) 
            VALUES ('$newAssetId', '$category_id', '$name', '$description', '$purchase_date', '$warranty_expiry', '$status', '$assigned_to', '$location', '$cost')";

    if ($conn->query($sql) === TRUE) {
        header("Location: manage_assets.php");
        exit;
    } else {
        echo "<p class='error'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Asset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin-top: 30px;
            margin-bottom: 30px;
            margin-left: 20%;
            margin-right: 20%;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 100%;
            width: 100%;
        }
        .container h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .container form {
            display: flex;
            flex-direction: column;
        }
        .container form label {
            margin-bottom: 5px;
            color: #333;
        }
        .container form input, .container form button, .container form select {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        .container form button {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .container form button:hover {
            background-color: #0056b3;
        }
        .success {
            color: green;
            text-align: center;
            margin-bottom: 20px;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 20px;
        }
        .container .go-back {
            background-color: #6c757d;
            color: #fff;
            text-align: center;
            border: none;
            cursor: pointer;
            padding: 10px;
            margin-top: 10px;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            width: 95%;
        }
        .container .go-back:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add New Asset</h1>
        <form method="POST" action="">
            <label for="category_name">Category:</label>
            <select name="category_name" required>
                <option value="">Select Category</option>
                <option value="Hardware">Hardware</option>
                <option value="Software">Software</option>
                <option value="Network">Network</option>
                <option value="Cloud">Cloud</option>
                <option value="Data">Data</option>
                <option value="Infrastructure">Infrastructure</option>
            </select>

            <label for="name">Name:</label>
            <input type="text" name="name" required>
            
            <label for="description">Description:</label>
            <input type="text" name="description" required>
            
            <label for="purchase_date">Purchase Date:</label>
            <input type="date" name="purchase_date" required>
            
            <label for="warranty_expiry">Warranty Expiry:</label>
            <input type="date" name="warranty_expiry" required>
            
            <label for="status">Status:</label>
            <select name="status" required>
                <option value="">Select Status</option>
                <option value="In Use">In Use</option>
                <option value="Under Maintenance">Under Maintenance</option>
                <option value="Retired">Retired</option>
            </select>
            
            <label for="assigned_to">Assigned To:</label>
            <input type="text" name="assigned_to" required>

            <label for="location">Location:</label>
            <input type="text" name="location" required>
            
            <label for="cost">Cost:</label>
            <input type="text" name="cost" required>
            
            <button type="submit">Add Asset</button>
        </form>
        <a href="manage_assets.php" class="go-back">Go Back</a>
    </div>
</body>
</html>
