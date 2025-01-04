<?php
session_start();
include('../includes/config.php');
include('../includes/functions.php');
redirectIfNotLoggedIn();

if (isset($_GET['id'])) {
    $maintenance_id = $_GET['id'];
    $sql = "DELETE FROM maintenance WHERE maintenance_id='$maintenance_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: manage_maintenance.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
