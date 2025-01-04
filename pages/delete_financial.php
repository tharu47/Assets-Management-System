<?php
session_start();
include('../includes/config.php');
include('../includes/functions.php');
redirectIfNotLoggedIn();

if (isset($_GET['id'])) {
    $financial_id = $_GET['id'];
    $sql = "DELETE FROM financial_records WHERE record_id='$financial_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: manage_financial.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
