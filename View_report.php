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

// Calculate pass/fail percentages
$sql_passed = "SELECT COUNT(*) AS passed_students FROM students WHERE (subject_code_1 >= 35 AND subject_code_2 >= 35 AND subject_code_3 >= 35 AND subject_code_4 >= 35 AND subject_code_5 >= 35)";
$passed_result = $conn->query($sql_passed);
$passed_students = $passed_result->fetch_assoc()['passed_students'];
$passed_percentage = ($passed_students / $total_students) * 100;
$failed_percentage = 100 - $passed_percentage;

// Number of students involved in extracurricular activities
$sql_extracurricular = "SELECT COUNT(*) AS involved_in_extracurricular FROM students WHERE extracurricular_activity > 0";
$extra_result = $conn->query($sql_extracurricular);
$involved_in_extracurricular = $extra_result->fetch_assoc()['involved_in_extracurricular'];

// Average marks for each subject
$average_marks = [];
for ($i = 1; $i <= 5; $i++) {
    $sql_avg = "SELECT AVG(subject_code_$i) AS avg_marks FROM students";
    $avg_result = $conn->query($sql_avg);
    $average_marks["subject_code_$i"] = $avg_result->fetch_assoc()['avg_marks'];
}

// Top 5 overall rankers by total marks
$sql_rankers = "SELECT student_name, enrollment_number, (subject_code_1 + subject_code_2 + subject_code_3 + subject_code_4 + subject_code_5) AS total_marks 
                FROM students ORDER BY total_marks DESC LIMIT 5";
$rankers_result = $conn->query($sql_rankers);
$rankers = [];
while ($row = $rankers_result->fetch_assoc()) {
    $rankers[] = $row;
}

// Top 5 rankers for each subject
$subject_rankers = [];
for ($i = 1; $i <= 5; $i++) {
    $sql_subject_rankers = "SELECT student_name, subject_code_$i AS subject_marks FROM students ORDER BY subject_code_$i DESC LIMIT 5";
    $subject_rankers_result = $conn->query($sql_subject_rankers);
    $subject_rankers["subject_code_$i"] = [];
    while ($row = $subject_rankers_result->fetch_assoc()) {
        $subject_rankers["subject_code_$i"][] = $row;
    }
}

// Attendance statistics
$sql_high_attendance = "SELECT COUNT(*) AS count_high_attendance FROM students WHERE attendance > 75";
$high_attendance_result = $conn->query($sql_high_attendance);
$students_above_75 = $high_attendance_result->fetch_assoc()['count_high_attendance'];

$sql_low_attendance = "SELECT student_name, attendance FROM students WHERE attendance < 75";
$low_attendance_result = $conn->query($sql_low_attendance);
$students_below_75 = [];
while ($row = $low_attendance_result->fetch_assoc()) {
    $students_below_75[] = $row;
}

// Top 5 attendance rankers
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
    <title>Generate Report - Annual Vision</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #111;
            color: #fff;
        }
        .navbar, .card {
            background-color: #222;
        }
        .navbar-brand img {
            width: 30px;
            height: 30px;
        }
        .table th, .table td {
            color: #fff;
        }
        .btn-primary {
            background: linear-gradient(45deg, #00ffff, #ff0096);
            border: none;
            color: white;
        }
        .btn-primary:hover {
            background: linear-gradient(45deg, #ff0096, #00ffff);
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
    <div class="card p-4">
        <h2 class="text-center mb-4">Generate Annual Report</h2>

        <div class="mb-4">
            <h3>Overall Performance</h3>
            <p><strong>Pass Percentage:</strong> <?php echo number_format($passed_percentage, 2); ?>%</p>
            <p><strong>Fail Percentage:</strong> <?php echo number_format($failed_percentage, 2); ?>%</p>
            <p><strong>Students in Extracurricular Activities:</strong> <?php echo $involved_in_extracurricular; ?> out of <?php echo $total_students; ?></p>
        </div>

        <div class="mb-4">
            <h3>Subject-wise Average Marks</h3>
            <ul>
                <?php foreach ($average_marks as $subject => $average): ?>
                    <li><strong><?php echo ucfirst(str_replace('_', ' ', $subject)); ?>:</strong> <?php echo number_format($average, 2); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="mb-4">
            <h3>Top 5 Overall Rankers</h3>
            <table class="table table-bordered">
                <thead><tr><th>Enrollment Number</th><th>Student Name</th><th>Total Marks</th></tr></thead>
                <tbody>
                    <?php foreach ($rankers as $ranker): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($ranker['enrollment_number']); ?></td>
                            <td><?php echo htmlspecialchars($ranker['student_name']); ?></td>
                            <td><?php echo htmlspecialchars($ranker['total_marks']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="mb-4">
            <h3>Top 5 Rankers per Subject</h3>
            <?php foreach ($subject_rankers as $subject => $rankers): ?>
                <h4><?php echo ucfirst(str_replace('_', ' ', $subject)); ?></h4>
                <table class="table table-bordered">
                    <thead><tr><th>Student Name</th><th>Marks</th></tr></thead>
                    <tbody>
                        <?php foreach ($rankers as $ranker): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($ranker['student_name']); ?></td>
                                <td><?php echo htmlspecialchars($ranker['subject_marks']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endforeach; ?>
        </div>

        <div class="mb-4">
            <h3>Attendance Statistics</h3>
            <p><strong>Attendance > 75%:</strong> <?php echo $students_above_75; ?></p>
            <p><strong>Attendance < 75%:</strong> <?php echo count($students_below_75); ?></p>
        </div>

        <div class="mb-4">
            <h3>Students with Attendance Below 75%</h3>
            <ul>
                <?php foreach ($students_below_75 as $student): ?>
                    <li><?php echo htmlspecialchars($student['student_name']); ?> - <?php echo htmlspecialchars($student['attendance']); ?>%</li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="mb-4">
            <h3>Top 5 Attendance Percentage Rankers</h3>
            <table class="table table-bordered">
                <thead><tr><th>Student Name</th><th>Attendance %</th></tr></thead>
                <tbody>
                    <?php foreach ($top_attendance as $student): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['student_name']); ?></td>
                            <td><?php echo htmlspecialchars($student['attendance']); ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <a href="generate_report.php" class="btn btn-info">Download as PDF</a>
    </div>
</div>

</body>
</html>
