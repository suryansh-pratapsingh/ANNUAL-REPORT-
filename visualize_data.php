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

// Fetch total students
$sql_total = "SELECT COUNT(*) AS total_students FROM students";
$total_result = $conn->query($sql_total);
$total_students = $total_result->fetch_assoc()['total_students'];

// Calculate passing percentage
$sql_passed = "SELECT COUNT(*) AS passed_students FROM students WHERE (subject_code_1 >= 35 AND subject_code_2 >= 35 AND subject_code_3 >= 35 AND subject_code_4 >= 35 AND subject_code_5 >= 35)";
$passed_result = $conn->query($sql_passed);
$passed_students = $passed_result->fetch_assoc()['passed_students'];
$passed_percentage = ($passed_students / $total_students) * 100;
$failed_percentage = 100 - $passed_percentage;

// Number of students involved in extracurricular activities
$sql_extracurricular = "SELECT COUNT(*) AS involved_in_extracurricular FROM students WHERE extracurricular_activity > 0";
$extra_result = $conn->query($sql_extracurricular);
$involved_in_extracurricular = $extra_result->fetch_assoc()['involved_in_extracurricular'];

// Average attendance percentage calculation
$sql_avg_attendance = "SELECT AVG(attendance) AS avg_attendance FROM students";
$avg_attendance_result = $conn->query($sql_avg_attendance);
$average_attendance = $avg_attendance_result->fetch_assoc()['avg_attendance'];

// Number of students with attendance > 75%
$sql_high_attendance = "SELECT COUNT(*) AS count_high_attendance FROM students WHERE attendance > 75";
$high_attendance_result = $conn->query($sql_high_attendance);
$students_above_75 = $high_attendance_result->fetch_assoc()['count_high_attendance'];

// Average marks calculation
$average_marks = [];
for ($i = 1; $i <= 5; $i++) {
    $sql_avg = "SELECT AVG(subject_code_$i) AS avg_marks FROM students";
    $avg_result = $conn->query($sql_avg);
    $average_marks["subject_code_$i"] = $avg_result->fetch_assoc()['avg_marks'];
}

// Top 5 rankers by total marks
$sql_rankers = "SELECT student_name, enrollment_number, (subject_code_1 + subject_code_2 + subject_code_3 + subject_code_4 + subject_code_5) AS total_marks 
                FROM students ORDER BY total_marks DESC LIMIT 5";
$rankers_result = $conn->query($sql_rankers);
$rankers = [];
while ($row = $rankers_result->fetch_assoc()) {
    $rankers[] = $row;
}

// Top 5 students by attendance
$sql_top_attendance = "SELECT student_name, attendance FROM students ORDER BY attendance DESC LIMIT 5";
$top_attendance_result = $conn->query($sql_top_attendance);
$top_attendance = [];
while ($row = $top_attendance_result->fetch_assoc()) {
    $top_attendance[] = $row;
}

$conn->close();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Visualization - Annual Vision</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        
        body {
            background-color: #111;
            color: #e0e0e0;
            overflow-x: hidden;
        }

        .navbar, .card {
            background-color: #222;
            color: #e0e0e0;
        }

        .navbar-brand img {
            width: 30px;
            height: 30px;
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
            from { transform: translate(-50%, -50%) rotate(0deg); }
            to { transform: translate(-50%, -50%) rotate(360deg); }
        }

        .card {
            border: none;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.4);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .btn-primary, .btn-success {
            background: linear-gradient(45deg, #00ffff, #ff0096);
            border: none;
            color: white;
        }

        .btn-primary:hover, .btn-success:hover {
            background: linear-gradient(45deg, #ff0096, #00ffff);
        }

        canvas {
            background-color: white;
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1rem;
        }

        table {
            width: 100%;
            color: #e0e0e0;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        .table th {
            background-color: #444;
            color: #e0e0e0;
        }

        .table td {
            background-color: white;
        }

        h3 {
            color: #ff0096;
            font-weight: bold;
            margin-top: 2rem;
        }
    </style>
</head>
<body>

<div class="background"></div>

<nav class="navbar navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php"><img src="l.png" alt="Logo"> Annual Vision</a>
        <a href="logout.php" class="btn btn-outline-light">Logout</a>
    </div>
    </nav>

<div class="container mt-5">
    <div class="card">
        <h2 class="text-center mb-4">Student Performance Visualization</h2>
        
        <div class="row">
            <!-- Pass/Fail Chart -->
            <div class="col-md-6">
                <h3 class="text-center">Pass/Fail Percentage</h3>
                <canvas id="passFailChart"></canvas>
            </div>
            
            <!-- Average Marks Chart -->
            <div class="col-md-6">
                <h3 class="text-center">Average Marks in Subjects</h3>
                <canvas id="avgMarksChart"></canvas>
            </div>
        </div>

        <div class="mt-5">
            <h3 class="text-center">Key Metrics</h3>
            <p class="text-center"><strong>Pass Percentage:</strong> <?php echo number_format($passed_percentage, 2); ?>%</p>
            <p class="text-center"><strong>Fail Percentage:</strong> <?php echo number_format($failed_percentage, 2); ?>%</p>
            <p class="text-center"><strong>Students Enrolled in Extracurricular Activities:</strong> <?php echo $involved_in_extracurricular; ?> out of <?php echo $total_students; ?></p>
            <p class="text-center"><strong>Average Attendance Percentage:</strong> <?php echo number_format($average_attendance, 2); ?>%</p>
            <p class="text-center"><strong>Students with Attendance > 75%:</strong> <?php echo $students_above_75; ?> out of <?php echo $total_students; ?></p>
        </div>

        <div class="mt-5">
            <h3>Top 5 Rankers</h3>
            <table class="table table-bordered">
                <tr><th>Enrollment Number</th><th>Student Name</th><th>Total Marks</th></tr>
                <?php foreach ($rankers as $ranker): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($ranker['enrollment_number']); ?></td>
                        <td><?php echo htmlspecialchars($ranker['student_name']); ?></td>
                        <td><?php echo htmlspecialchars($ranker['total_marks']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div class="mt-5">
            <h3>Top 5 Attendance Percentage Rankers</h3>
            <table class="table table-bordered">
                <tr><th>Student Name</th><th>Attendance %</th></tr>
                <?php foreach ($top_attendance as $student): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student['student_name']); ?></td>
                        <td><?php echo htmlspecialchars($student['attendance']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>

<script>
    // Pass/Fail Percentage Chart
    new Chart(document.getElementById('passFailChart'), {
        type: 'pie',
        data: {
            labels: ['Passed', 'Failed'],
            datasets: [{
                label: 'Pass/Fail Percentage',
                data: [<?php echo $passed_percentage; ?>, <?php echo $failed_percentage; ?>],
                backgroundColor: ['#4CAF50', '#FF5252'],
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true, position: 'bottom' }
            }
        }
    });

    // Average Marks Bar Chart
    new Chart(document.getElementById('avgMarksChart'), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_keys($average_marks)); ?>,
            datasets: [{
                label: 'Average Marks',
                data: <?php echo json_encode(array_values($average_marks)); ?>,
                backgroundColor: ['#FFA726', '#66BB6A', '#42A5F5', '#AB47BC', '#FF7043'],
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>

</body>
</html>