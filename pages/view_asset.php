<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        .container {
            width: 60%;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .asset-details {
            margin-top: 20px;
        }
        .asset-details div {
            margin-bottom: 10px;
            padding: 10px;
            background: #f9f9f9;
            border-left: 4px solid #007BFF;
        }
        .asset-details div span {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Asset Details</h1>
        <div class="asset-details">
            <?php
            session_start();
            include('../includes/config.php');
            include('../includes/functions.php');
            redirectIfNotLoggedIn();

            if (isset($_GET['id'])) {
                $asset_id = $_GET['id'];
                $sql = "SELECT * FROM assets WHERE asset_id = '$asset_id'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "<div><span>Asset ID:</span> " . $row['asset_id'] . "</div>";
                    echo "<div><span>Name:</span> " . $row['name'] . "</div>";
                    echo "<div><span>Description:</span> " . $row['description'] . "</div>";
                    echo "<div><span>Purchase Date:</span> " . $row['purchase_date'] . "</div>";
                    echo "<div><span>Warranty Expiry:</span> " . $row['warranty_expiry'] . "</div>";
                    echo "<div><span>Status:</span> " . $row['status'] . "</div>";
                    echo "<div><span>Assigned_to:</span> " . $row['assigned_to'] . "</div>";
                    echo "<div><span>Location:</span> " . $row['location'] . "</div>";
                    echo "<div><span>Cost:</span> " . $row['cost'] . "</div>";
                } else {
                    echo "<div>No asset found with ID $asset_id</div>";
                }
            } else {
                echo "<div>No asset ID specified.</div>";
            }
            ?>
        </div>
    </div>
</body>
</html>
