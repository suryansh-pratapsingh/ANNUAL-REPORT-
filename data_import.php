<?php
require 'vendor/autoload.php'; // Load PhpSpreadsheet classes
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

// Database connection
$servername = "localhost";
$db_username = "root";
$db_password = "";
$database = "tut";

$conn = new mysqli($servername, $db_username, $db_password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$import_success = false; // Flag to check successful import

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $department_name = $_POST['department_name'];
    $year_of_class = $_POST['year_of_class'];
    $section = $_POST['section'];

    $sql_class = "INSERT INTO class_details (department_name, year_of_class, section) VALUES (?, ?, ?)";
    $stmt_class = $conn->prepare($sql_class);
    $stmt_class->bind_param("sss", $department_name, $year_of_class, $section);
    $stmt_class->execute();
    $class_id = $stmt_class->insert_id;

    if (isset($_FILES['student_file']) && $_FILES['student_file']['error'] == 0) {
        $filePath = $_FILES['student_file']['tmp_name'];
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();

        foreach ($sheet->getRowIterator(2) as $row) {
            $enrollment_number = $sheet->getCell('A' . $row->getRowIndex())->getValue();
            $student_name = $sheet->getCell('B' . $row->getRowIndex())->getValue();
            $subject_code_1 = $sheet->getCell('C' . $row->getRowIndex())->getValue();
            $subject_code_2 = $sheet->getCell('D' . $row->getRowIndex())->getValue();
            $subject_code_3 = $sheet->getCell('E' . $row->getRowIndex())->getValue();
            $subject_code_4 = $sheet->getCell('F' . $row->getRowIndex())->getValue();
            $subject_code_5 = $sheet->getCell('G' . $row->getRowIndex())->getValue();
            $attendance = $sheet->getCell('H' . $row->getRowIndex())->getValue();
            $extracurricular_activity = $sheet->getCell('I' . $row->getRowIndex())->getValue();

            $sql_student = "INSERT INTO students (enrollment_number, student_name, subject_code_1, subject_code_2, subject_code_3, subject_code_4, subject_code_5, attendance, extracurricular_activity, class_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_student = $conn->prepare($sql_student);
            $stmt_student->bind_param("ssiiiiisii", $enrollment_number, $student_name, $subject_code_1, $subject_code_2, $subject_code_3, $subject_code_4, $subject_code_5, $attendance, $extracurricular_activity, $class_id);
            $stmt_student->execute();
        }
        echo "<div class='alert alert-success text-center'>Data imported successfully.</div>";
        $import_success = true; // Set flag to true after successful import
    } else {
        echo "<div class='alert alert-danger text-center'>Failed to upload file.</div>";
    }
    $stmt_class->close();
    $conn->close();
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Import - Annual Vision</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background: #111;
        color: white;
        overflow: hidden;
    }

    .form-label,
    .form-control,
    .card h2,
    .navbar-brand,
    .btn {
        color: #e0e0e0;
    }

    .card {
        background-color: #222;
        border: none;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.4);
    }

    input.form-control {
        background-color: #333;
        color: #e0e0e0;
        border: 1px solid #555;
    }

    input.form-control:focus {
        background-color: #444;
        color: white;
        border-color: #666;
        box-shadow: none;
    }

    .btn-primary {
        background: linear-gradient(45deg, #00ffff, #ff0096);
        border: none;
    }

    .btn-primary:hover {
        background: linear-gradient(45deg, #ff0096, #00ffff);
    }

    .btn-success,
    .btn-info {
        background: linear-gradient(45deg, #00ffff, #ff0096);
        border: none;
        color: white;
    }

    .btn-success:hover,
    .btn-info:hover {
        background: linear-gradient(45deg, #ff0096, #00ffff);
    }

    .background {
        position: fixed;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, rgba(0, 255, 255, 0.2), rgba(255, 0, 150, 0.2));
        animation: moveBackground 10s linear infinite;
        z-index: -1;
    }

    @keyframes moveBackground {
        from {
            transform: translate(-50%, -50%) rotate(0deg);
        }

        to {
            transform: translate(-50%, -50%) rotate(360deg);
        }
    }
    </style>
</head>

<body>
    <div class="background"></div>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php"><img src="l.png" alt="Logo" width="30" height="30"
                    class="d-inline-block align-top"> Annual Vision</a>
            <div><a href="logout.php" class="btn btn-outline-light">Logout</a></div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Data Import</h2>
        <div class="card p-4 shadow">
            <form action="data_import.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="department_name" class="form-label">Department Name</label>
                    <input type="text" name="department_name" class="form-control" id="department_name" required>
                </div>
                <div class="mb-3">
                    <label for="year_of_class" class="form-label">Year of Class</label>
                    <input type="number" name="year_of_class" class="form-control" id="year_of_class" required>
                </div>
                <div class="mb-3">
                    <label for="section" class="form-label">Section</label>
                    <input type="text" name="section" class="form-control" id="section" required>
                </div>
                <div class="mb-3">
                    <label for="student_file" class="form-label">Student Data (Excel)</label>
                    <input type="file" name="student_file" class="form-control" id="student_file" accept=".xls,.xlsx"
                        required>
                </div>
                <button type="submit" class="btn btn-primary">Upload and Import Data</button>
            </form>

            <?php if ($import_success): ?>
            <div class="mt-4 text-center">
                <a href="visualize_data.php" class="btn btn-success me-2">Visualize Data</a>
                <a href="View_report.php" class="btn btn-info">Generate Report</a>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>