<?php
session_start();
include('../includes/config.php');
include('../includes/functions.php');
redirectIfNotLoggedIn();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $asset_id = $_POST['asset_id'];
    $category_name = $_POST['category_name'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $purchase_date = $_POST['purchase_date'];
    $warranty_expiry = $_POST['warranty_expiry'];
    $status = $_POST['status'];
    $location = $_POST['location'];
    $cost = $_POST['cost'];

    // Map category names to category IDs
    $categories = [
        'Hardware' => "CAT0001",
        'Software' => "CAT0002",
        'Network' => "CAT0003",
        'Cloud' => "CAT0004",
        'Data' => "CAT0005",
        'Infrastructure' => "CAT0006"
    ];

    // Validate and get category_id from category_name
    if (!array_key_exists($category_name, $categories)) {
        echo "<p class='error'>Invalid category name.</p>";
        exit;
    }

    $category_id = $categories[$category_name];

    $sql = "UPDATE assets 
            SET category_id = '$category_id', name = '$name', description = '$description', purchase_date = '$purchase_date', 
                warranty_expiry = '$warranty_expiry', status = '$status', location = '$location', cost = '$cost'
            WHERE asset_id = '$asset_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: manage_assets.php");
        exit;
    } else {
        echo "<p class='error'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }

    $conn->close();
}

// Fetch asset details for editing
if (isset($_GET['id'])) {
    $asset_id = $_GET['id'];
    $result = $conn->query("SELECT * FROM assets WHERE asset_id = '$asset_id'");

    if ($result->num_rows == 1) {
        $asset = $result->fetch_assoc();
    } else {
        echo "<p class='error'>Asset not found.</p>";
        exit;
    }
} else {
    echo "<p class='error'>No asset ID provided.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Asset</title>
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
        }
        .container .go-back:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Asset</h1>
        <form method="POST" action="">
            <input type="hidden" name="asset_id" value="<?php echo $asset['asset_id']; ?>">

            <label for="category_name">Category:</label>
            <select name="category_name" required>
                <option value="">Select Category</option>
                <option value="Hardware" <?php echo $asset['category_id'] == 'CAT0001' ? 'selected' : ''; ?>>Hardware</option>
                <option value="Software" <?php echo $asset['category_id'] == 'CAT0002' ? 'selected' : ''; ?>>Software</option>
                <option value="Network" <?php echo $asset['category_id'] == 'CAT0003' ? 'selected' : ''; ?>>Network</option>
                <option value="Cloud" <?php echo $asset['category_id'] == 'CAT0004' ? 'selected' : ''; ?>>Cloud</option>
                <option value="Data" <?php echo $asset['category_id'] == 'CAT0005' ? 'selected' : ''; ?>>Data</option>
                <option value="Infrastructure" <?php echo $asset['category_id'] == 'CAT0006' ? 'selected' : ''; ?>>Infrastructure</option>
            </select>

            <label for="name">Name:</label>
            <input type="text" name="name" value="<?php echo $asset['name']; ?>" required>
            
            <label for="description">Description:</label>
            <input type="text" name="description" value="<?php echo $asset['description']; ?>" required>
            
            <label for="purchase_date">Purchase Date:</label>
            <input type="date" name="purchase_date" value="<?php echo $asset['purchase_date']; ?>" required>
            
            <label for="warranty_expiry">Warranty Expiry:</label>
            <input type="date" name="warranty_expiry" value="<?php echo $asset['warranty_expiry']; ?>" required>
            
            <label for="status">Status:</label>
            <select name="status" required>
                <option value="In Use" <?php echo $asset['status'] == 'In Use' ? 'selected' : ''; ?>>In Use</option>
                <option value="Under Maintenance" <?php echo $asset['status'] == 'Under Maintenance' ? 'selected' : ''; ?>>Under Maintenance</option>
                <option value="Retired" <?php echo $asset['status'] == 'Retired' ? 'selected' : ''; ?>>Retired</option>
            </select>
            
            <label for="location">Location:</label>
            <input type="text" name="location" value="<?php echo $asset['location']; ?>" required>
            
            <label for="cost">Cost:</label>
            <input type="text" name="cost" value="<?php echo $asset['cost']; ?>" required>
            
            <button type="submit">Update Asset</button>
        </form>
        <a href="manage_assets.php" class="go-back">Go Back</a>
    </div>
</body>
</html>
