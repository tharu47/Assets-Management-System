<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assets Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: white;
            margin-top: 50px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px; /* Optional: Set a fixed width for better layout control */
        }

        h1 {
            margin-bottom: 20px;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            background-color: rgb(7, 7, 125);
            color: white;
            border: none;
            border-radius: 4px;
            margin: 5px; /* Add some margin between buttons */
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Generate Report </h1>
        <div class="dashboard">
            <form method="post" action="">
                <button type="submit" name="viewReportsButton">View Reports</button>
            </form>
            <button onclick="goBack()">Back to Dashboard</button>
        </div>
    </div>

    <script>
        function goBack() {
            window.location.href = 'dashboard.php';
        }
    </script>

    <?php
if (isset($_POST['viewReportsButton'])) {
    ob_start(); // Start output buffering

    require('fpdf/fpdf.php');

    // Database connection
    function getDatabaseConnection() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bci_asset_system";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }

    // Fetch Maintenance data
    function getMaintenanceData($conn) {
        $sql = "SELECT maintenance_id, asset_id, maintenance_date, maintenance_type, description, cost, status FROM maintenance";
        $result = $conn->query($sql);

        $maintenance = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $maintenance[] = $row;
            }
        }
        return $maintenance;
    }

    // Fetch Work Orders data
    function getWorkOrdersData($conn) {
        $sql = "SELECT work_order_id, asset_id, assigned_to, issue_description, start_date, end_date, status FROM work_orders";
        $result = $conn->query($sql);

        $work_orders = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $work_orders[] = $row;
            }
        }
        return $work_orders;
    }

    // Fetch Financial data
    function getFinancialData($conn) {
        $sql = "SELECT record_id, asset_id, transaction_date, amount, type, description FROM financial_records";
        $result = $conn->query($sql);

        $financial = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $financial[] = $row;
            }
        }
        return $financial;
    }

    class PDF extends FPDF {
        // Page header
        function Header() {
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 10, 'BCI IT Assets Management System Report', 0, 1, 'C');
            $this->Ln(10);
        }

        // Page footer
        function Footer() {
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
        }

        function ChapterTitle($title) {
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 10, $title, 0, 1, 'L');
            $this->Ln(4);
        }

        function ChapterBody($text) {
            $this->SetFont('Arial', '', 12);
            $this->MultiCell(0, 10, $text);
            $this->Ln(10);
        }

        function BulletPoints($points) {
            $this->SetFont('Arial', '', 12);
            foreach ($points as $point) {
                $this->Cell(5, 10, chr(149), 0, 0); // Bullet point
                $this->MultiCell(0, 10, $point);
                $this->Ln(2);
            }
            $this->Ln(10);
        }
    }

    $conn = getDatabaseConnection();
    $pdf = new PDF();
    $pdf->AddPage();

    // Maintenance Report
    $pdf->ChapterTitle('Maintenance Report');
    $maintenanceData = getMaintenanceData($conn);
    $maintenanceText = "Maintenance activities performed on various assets. Below are the details:";
    $pdf->ChapterBody($maintenanceText);

    $maintenancePoints = [];
    foreach ($maintenanceData as $item) {
        $maintenancePoints[] = "ID: {$item['maintenance_id']}, Asset ID: {$item['asset_id']}, Date: {$item['maintenance_date']}, Type: {$item['maintenance_type']}, Description: {$item['description']}, Cost: {$item['cost']}, Status: {$item['status']}";
    }
    $pdf->BulletPoints($maintenancePoints);

    // Work Orders Report
    $pdf->ChapterTitle('Work Orders Report');
    $workOrdersData = getWorkOrdersData($conn);
    $workOrdersText = "Work orders assigned to various personnel. Below are the details:";
    $pdf->ChapterBody($workOrdersText);

    $workOrdersPoints = [];
    foreach ($workOrdersData as $item) {
        $workOrdersPoints[] = "ID: {$item['work_order_id']}, Asset ID: {$item['asset_id']}, Assigned To: {$item['assigned_to']}, Description: {$item['issue_description']}, Start Date: {$item['start_date']}, End Date: {$item['end_date']}, Status: {$item['status']}";
    }
    $pdf->BulletPoints($workOrdersPoints);

    // Financial Report
    $pdf->ChapterTitle('Financial Report');
    $financialData = getFinancialData($conn);
    $financialText = "Financial transactions related to assets. Below are the details:";
    $pdf->ChapterBody($financialText);

    $financialPoints = [];
    foreach ($financialData as $item) {
        $financialPoints[] = "ID: {$item['record_id']}, Asset ID: {$item['asset_id']}, Transaction Date: {$item['transaction_date']}, Amount: {$item['amount']}, Type: {$item['type']}, Description: {$item['description']}";
    }
    $pdf->BulletPoints($financialPoints);

    $pdf->Output('D', 'report.pdf'); // Output to browser and force download

    $conn->close();
    ob_end_flush(); // End output buffering and flush output
}
?>
</body>
</html>