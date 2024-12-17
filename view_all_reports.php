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

// Fetch all reports
$sql = "SELECT report_id, department_name, year_of_class, section FROM class_details";
$result = $conn->query($sql);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Reports - Annual Vision</title>
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

<nav class="navbar navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php"><img src="l.png" alt="Logo"> Annual Vision</a>
        <a href="logout.php" class="btn btn-outline-light">Logout</a>
    </div>
</nav>

<div class="container mt-5">
    <div class="card p-4">
        <h2 class="text-center mb-4">All Generated Reports</h2>
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Report Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?php
                        // Merge department, year, and section to create the report name
                        $report_name = $row['department_name'] . ' - ' . $row['year_of_class'] . ' - ' . $row['section'];
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($report_name); ?></td>
                            <td>
                                <a href="download_report.php?id=<?php echo $row['report_id']; ?>" class="btn btn-primary btn-sm">Download</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center">No reports generated yet.</p>
        <?php endif; ?>
    </div>
</div>

<?php
$conn->close();
?>

</body>
</html>
