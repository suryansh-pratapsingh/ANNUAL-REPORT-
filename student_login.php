<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Login - Annual Vision</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #111;
            color: white;
            overflow: hidden;
        }

        #su {
            color: #fff;
        }

        .form-label {
            color: black;
        }

        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, rgba(0, 255, 255, 0.2), rgba(255, 0, 150, 0.2));
            animation: moveBackground 10s linear infinite;
            z-index: -1;
            transform: translate(-50%, -50%);
        }

        @keyframes moveBackground {
            from {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            to {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        .text-light{
            color: rgb(0 128 255) !important;
        }

    </style>
</head>

<body>
    <!-- Animated Background -->
    <div class="background"></div>

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="l.png" alt="Logo" width="30" height="30" class="d-inline-block align-top">
                Annual Vision
            </a>
            <div>
                <a href="signup.php" class="btn btn-outline-light">Sign Up</a>
            </div>
        </div>
    </nav>

    <!-- Login Form -->
    <div class="container mt-5">
        <h2 class="text-center mb-4" id="su">Student Login</h2>
        <div class="card p-4 shadow">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" id="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                </div>
                <div class="mb-3">
                    <label for="enrollment_number" class="form-label">Enrollment Number</label>
                    <input type="text" name="enrollment_number" class="form-control" id="enrollment_number" required>
                </div>
                <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
            </form>
            <div class="text-center mt-3">
                <a id="l" href="login.php" class="text-light">Login as Faculty</a>
            </div>
        </div>
    </div>

    <!-- PHP Logic -->
    <?php
    if (isset($_POST['login'])) {
        $servername = "localhost";
        $db_username = "root";
        $db_password = "";
        $database = "tut";

        $conn = mysqli_connect($servername, $db_username, $db_password, $database);

        if (!$conn) {
            die("<div class='alert alert-danger text-center'>Connection failed: " . mysqli_connect_error() . "</div>");
        }

        $username = $_POST['username'];
        $password = $_POST['password'];
        $enrollment_number = $_POST['enrollment_number'];

        // Check if username and password are valid
        $checkUser = "SELECT * FROM user WHERE username='$username'";
        $result = mysqli_query($conn, $checkUser);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                // Check if enrollment number exists for this student
                $checkStudent = "SELECT * FROM students WHERE enrollment_number='$enrollment_number' AND class_id IN (SELECT class_id FROM class_details WHERE department_name='CSE')";
                $student_result = mysqli_query($conn, $checkStudent);

                if (mysqli_num_rows($student_result) === 1) {
                    $student_row = mysqli_fetch_assoc($student_result);

                    // Start the session and store student data
                    session_start();
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $username;
                    $_SESSION['enrollment_number'] = $enrollment_number;
                    $_SESSION['student_name'] = $student_row['student_name'];
                    $_SESSION['class_id'] = $student_row['class_id'];

                    // Redirect to student dashboard
                    header("Location: student_dashboard.php");
                    exit();
                } else {
                    echo "<div class='alert alert-danger text-center mt-3'>Enrollment number not found.</div>";
                }
            } else {
                echo "<div class='alert alert-danger text-center mt-3'>Incorrect username or password.</div>";
            }
        } else {
            echo "<div class='alert alert-danger text-center mt-3'>Incorrect username or password.</div>";
        }
        mysqli_close($conn);
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
