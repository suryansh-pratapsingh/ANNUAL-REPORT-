<?php
// Database connection
$servername = "localhost";
$db_username = "root";
$db_password = "";
$database = "tut";

$conn = new mysqli($servername, $db_username, $db_password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get report ID from URL
$id = $_GET['id'];

// Fetch the report from the database
$sql = "SELECT report FROM class_details WHERE report_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($pdf_report);
$stmt->fetch();

// Output PDF file for download
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="report.pdf"');
echo $pdf_report;

$conn->close();
?>
