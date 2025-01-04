<?php
session_start();
include('../includes/config.php');
include('../includes/functions.php');
redirectIfNotLoggedIn();

if (isset($_GET['id'])) {
    $maintenance_id = $_GET['id'];

    // Fetch the maintenance record
    $sql = "SELECT * FROM maintenance WHERE maintenance_id = '$maintenance_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "No record found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $asset_id = $_POST['asset_id'];
    $maintenance_date = $_POST['maintenance_date'];
    $maintenance_type = $_POST['maintenance_type'];
    $description = $_POST['description'];
    $cost = $_POST['cost'];
    $status = $_POST['status'];

    $sql = "UPDATE maintenance SET 
                asset_id='$asset_id', 
                maintenance_date='$maintenance_date', 
                maintenance_type='$maintenance_type', 
                description='$description', 
                cost='$cost', 
                status='$status' 
            WHERE maintenance_id='$maintenance_id'";

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
    <title>Edit Maintenance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
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
            width: 100%;
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
        <h1>Edit Maintenance Record</h1>
        <form method="POST" action="edit_maintenance.php?id=<?php echo $maintenance_id; ?>">
            <label for="asset_id">Asset ID:</label>
            <input type="text" id="asset_id" name="asset_id" value="<?php echo $row['asset_id']; ?>" required>

            <label for="maintenance_date">Maintenance Date:</label>
            <input type="date" id="maintenance_date" name="maintenance_date" value="<?php echo $row['maintenance_date']; ?>" required>

            <label for="maintenance_type">Maintenance Type:</label>
            <input type="text" id="maintenance_type" name="maintenance_type" value="<?php echo $row['maintenance_type']; ?>" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?php echo $row['description']; ?></textarea>

            <label for="cost">Cost:</label>
            <input type="number" step="0.01" id="cost" name="cost" value="<?php echo $row['cost']; ?>" required>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="scheduled" <?php if ($row['status'] == 'scheduled') echo 'selected'; ?>>Scheduled</option>
                <option value="in progress" <?php if ($row['status'] == 'in progress') echo 'selected'; ?>>In Progress</option>
                <option value="completed" <?php if ($row['status'] == 'completed') echo 'selected'; ?>>Completed</option>
            </select>

            <button type="submit">Update Maintenance</button>
        </form>
        <form action="manage_maintenance.php">
            <button type="submit" class="back-button">Go Back</button>
        </form>
    </div>
</body>
</html>