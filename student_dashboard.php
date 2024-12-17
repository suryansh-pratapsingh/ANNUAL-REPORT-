<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: student_login.php");
    exit();
}

$servername = "localhost";
$db_username = "root";
$db_password = "";
$database = "tut";
$conn = mysqli_connect($servername, $db_username, $db_password, $database);

if (!$conn) {
    die("<div class='alert alert-danger text-center'>Connection failed: " . mysqli_connect_error() . "</div>");
}

$enrollment_number = $_SESSION['enrollment_number'];
$query = "SELECT * FROM students WHERE enrollment_number='$enrollment_number'";
$result = mysqli_query($conn, $query);
$student = mysqli_fetch_assoc($result);

mysqli_close($conn);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Dashboard - Annual Vision</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #111;
            color: white;
        }

        .navbar-brand {
            font-weight: bold;
        }

        .dashboard-card {
            background-color: #222;
            border: 1px solid #444;
            border-radius: 10px;
            color: #ddd;
        }

        .dashboard-card h4 {
            color: #00d4ff;
        }

        .section-heading {
            margin-top: 20px;
            margin-bottom: 10px;
            font-size: 1.5rem;
            color: #ff4fff;
            border-bottom: 2px solid #444;
            display: inline-block;
            padding-bottom: 5px;
        }

        .card p {
            margin: 5px 0;
        }

        .dashboard-container {
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="l.png" alt="Logo" width="30" height="30" class="d-inline-block align-top">
                Annual Vision
            </a>
            <div>
                <a href="logout.php" class="btn btn-outline-light">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Dashboard Content -->
    <div class="container dashboard-container">
        <h2 class="text-center mb-4">Welcome, <?php echo $_SESSION['student_name']; ?>!</h2>

        <!-- Marks Section -->
        <div class="card dashboard-card p-4 mb-4">
            <h4 class="section-heading">Marks</h4>
            <p><strong>Subject 1:</strong> <?php echo $student['subject_code_1']; ?></p>
            <p><strong>Subject 2:</strong> <?php echo $student['subject_code_2']; ?></p>
            <p><strong>Subject 3:</strong> <?php echo $student['subject_code_3']; ?></p>
            <p><strong>Subject 4:</strong> <?php echo $student['subject_code_4']; ?></p>
            <p><strong>Subject 5:</strong> <?php echo $student['subject_code_5']; ?></p>
        </div>

        <!-- Attendance Section -->
        <div class="card dashboard-card p-4">
            <h4 class="section-heading">Attendance & Extracurricular</h4>
            <p><strong>Attendance:</strong> <?php echo $student['attendance']; ?>%</p>
            <p><strong>Extracurricular Activities:</strong> <?php echo $student['extracurricular_activity']; ?></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
