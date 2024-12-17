<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home - Annual Vision</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

        .main-content {
            margin-top: 50px;
            margin-bottom: 50px;
            text-align: center;
        }

        .section-title {
            color: #ff6f61;
            margin-bottom: 30px;
            font-weight: bold;
            text-align: center;
        }

        .feature-item {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            transition: transform 0.3s ease, background 0.3s ease, box-shadow 0.3s ease;
        }

        .feature-item:hover {
            color: tomato;
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .footer {
            background-color: #222;
            color: #ccc;
            padding: 15px 0;
            text-align: center;
            font-size: 0.9rem;
            margin-top: 50px;
        }

        .row {
            gap: 22px;
            justify-content: center;
        }

        .fade-in {
            opacity: 0;
            animation: fadeIn 2s forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .container {
            max-width: 1200px;
        }

        .feature-item h4 {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .feature-item p {
            font-size: 0.9rem;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <div class="background"></div>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="l.png" alt="Logo" width="30" height="30" class="d-inline-block align-top">
                Annual Vision
            </a>
            <div>
                <a href="login.php" class="btn btn-outline-light">Login</a>
                <a href="signup.php" class="btn btn-outline-light ms-2">Sign Up</a>
            </div>
        </div>
    </nav>

    <div class="container main-content fade-in">
        <h1 class="mb-4">Welcome to Annual Vision</h1>
        <p class="lead mb-5">
            Automate student performance tracking with intuitive data analysis and visualization.
        </p>

        <!-- About Section -->
        <div class="text-center mb-5">
            <h2 class="section-title">About Annual Vision</h2>
            <p class="mx-auto" style="max-width: 700px;">
                Annual Vision is an innovative web application designed for educational institutions to streamline
                student performance reporting. Faculty can easily import data, analyze academic and extracurricular
                trends, and generate comprehensive reports with data visualizations.
            </p>
        </div>

        <!-- Features Section -->
        <div class="text-center">
            <h2 class="section-title">Features</h2>
            <div class="row">
                <div class="col-md-4 feature-item">
                    <h4>Automated Data Import</h4>
                    <p>Quickly upload student information, including marks, attendance, and extracurricular activities, via Excel files.</p>
                </div>
                <div class="col-md-4 feature-item">
                    <h4>Comprehensive Reports</h4>
                    <p>Generate detailed performance reports for each student or class, including subject-wise analysis and rankings.</p>
                </div>
                <div class="col-md-4 feature-item">
                    <h4>Data Visualization</h4>
                    <p>Gain insights through interactive charts and graphs that showcase trends and performance comparisons.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 feature-item">
                    <h4>PDF Report Generation</h4>
                    <p>Create downloadable PDF reports for easy sharing and record-keeping.</p>
                </div>
                <div class="col-md-4 feature-item">
                    <h4>Top 10 Ranking Insights</h4>
                    <p>Identify and display the top 10 students in each class based on overall performance.</p>
                </div>
                <div class="col-md-4 feature-item">
                    <h4>Real-Time Analysis</h4>
                    <p>Get instant feedback on uploaded data with performance summaries for students and classes.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Developed by Suryansh Pratap Singh and Team under the guidance of Shushma Khatri Ma'am.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
