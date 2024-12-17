<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Annual Vision</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
    body {
        background: #111;
        color: white;
        overflow-x: hidden;
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

    h2 {
        color: #fff;
    }

    .card,
    .navbar {
        background-color: #222;
    }

    .card-title {
        color: #00cccc;
    }

    .section-title {
        margin-top: 30px;
    }

    .footer {
        margin-top: 20px;
        padding: 10px 0;
        background-color: #222;
        color: #ddd;
        text-align: center;
    }
    </style>
</head>

<body>
    <div class="background"></div>

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

    <!-- Project Introduction Section -->
    <div class="container mt-5">
        <h2 class="text-center section-title">Project Overview</h2>
        <div class="card p-4 shadow mt-3">
            <h5 class="card-title">Annual Vision - Automated Student Report System</h5>
            <p class="card-text">
                *Annual Vision* is an automated report generation tool designed to streamline student performance
                analysis for faculty. Using imported data from an Excel sheet that includes student enrollment details,
                subject-wise marks, attendance, and extracurricular engagements, *Annual Vision* performs comprehensive
                data analysis to generate detailed reports. Key features include:
            </p>
            <ul>
                <li>Subject-wise performance analysis</li>
                <li>Top 10 ranking students based on overall scores</li>
                <li>Data visualization with charts and graphs</li>
                <li>Exportable PDF reports for each class</li>
            </ul>
            <p class="card-text">
                The dashboard provides options for data import, viewing all generated reports, and accessing support
                resources.
            </p>
        </div>
    </div>

    <!-- Dashboard Options -->
    <div class="container mt-5">
        <h2 class="text-center section-title">Dashboard</h2>
        <div class="row mt-3 text-center">
            <!-- Data Import Option -->
            <div class="col-md-4 mb-4">
                <div class="card p-3 shadow">
                    <i class="fas fa-file-upload fa-2x text-info mb-3"></i>
                    <h5 class="card-title">Data Import</h5>
                    <p class="card-text">Upload an Excel sheet to analyze and generate student reports.</p>
                    <a href="data_import.php" class="btn btn-primary">Go to Data Import</a>
                </div>
            </div>
            <!-- View All Reports Option -->
            <div class="col-md-4 mb-4">
                <div class="card p-3 shadow">
                    <i class="fas fa-file-alt fa-2x text-warning mb-3"></i>
                    <h5 class="card-title">View All Reports</h5>
                    <p class="card-text">Access all generated reports to review past student performance data.</p>
                    <a href="view_all_reports.php" class="btn btn-primary">View Reports</a>
                </div>
            </div>
            <!-- Help and Support Option -->
            <div class="col-md-4 mb-4">
                <div class="card p-3 shadow">
                    <i class="fas fa-headset fa-2x text-success mb-3"></i>
                    <h5 class="card-title">Help & Support</h5>
                    <p class="card-text">Access FAQs and contact support for assistance.</p>
                    <a href="support.php" class="btn btn-primary">Get Support</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Developed by Suryansh Pratap Singh and Team under the guidance of Shushma Khatri Ma'am.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>