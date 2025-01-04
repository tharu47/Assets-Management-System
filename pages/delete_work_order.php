<?php
session_start();
include('../includes/config.php');
include('../includes/functions.php');
redirectIfNotLoggedIn();

if (isset($_GET['id'])) {
    $work_order_id = $_GET['id'];
    $sql = "DELETE FROM work_orders WHERE work_order_id='$work_order_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: manage_work_orders.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
