<?php
session_start();
include('../includes/config.php');
include('../includes/functions.php');
redirectIfNotLoggedIn();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $asset_id = $_GET['id'];

    $sql = "DELETE FROM assets WHERE asset_id='$asset_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Asset deleted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
    header('Location: manage_assets.php');
    exit();
}
?>
