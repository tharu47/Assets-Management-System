<?php
session_start();
include('../includes/config.php');

// Function to generate notifications based on maintenance dates
function generateMaintenanceNotifications($conn) {
    $notifications = [];
    $today = date("Y-m-d");

    // Query for upcoming maintenance (next 7 days)
    $query = "SELECT asset_id, maintenance_date FROM maintenance WHERE maintenance_date BETWEEN '$today' AND DATE_ADD('$today', INTERVAL 7 DAY)";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $notifications[] = "Asset #" . $row['asset_id'] . " needs maintenance by " . $row['maintenance_date'] . ".";
        }
    }

    // Additional queries for other types of notifications can be added here

    return $notifications;
}

// Fetch notifications
$notifications = generateMaintenanceNotifications($conn);

// Store notifications in session
$_SESSION['notifications'] = $notifications;

header("Location: dashboard.php");
exit;
?>
