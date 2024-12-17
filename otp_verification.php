<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OTP Verification - Annual Vision</title>
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
            <a class="navbar-brand" href="#">
                <img src="l.png" alt="Logo" width="30" height="30" class="d-inline-block align-top">
                Annual Vision
            </a>
            <div>
                <a href="login.php" class="btn btn-outline-light">Login</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-4" id="su">OTP Verification</h2>
        <div class="card p-4 shadow">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="otp" class="form-label">Enter OTP</label>
                    <input type="text" name="otp" class="form-control" id="otp" required>
                </div>
                <button type="submit" name="verify_otp" class="btn btn-primary">Verify OTP</button>
            </form>
            <div class="text-center mt-3">
                <a href="signup.php">Back to Sign Up</a>
            </div>
        </div>
    </div>

    <?php
session_start();  // Start the session at the very beginning

if (!isset($_SESSION['email'])) {
    die("<div class='alert alert-danger text-center'>Session expired or invalid. Please sign up again.</div>");
}

if (isset($_POST['verify_otp'])) {
    $entered_otp = $_POST['otp'];
    if ($entered_otp == $_SESSION['otp']) {
        $servername = "localhost";
        $db_username = "root";
        $db_password = "";
        $database = "tut";

        $conn = mysqli_connect($servername, $db_username, $db_password, $database);
        if (!$conn) {
            die("<div class='alert alert-danger text-center'>Connection failed: " . mysqli_connect_error() . "</div>");
        }

        $username = $_SESSION['username'];
        $email = $_SESSION['email'];
        $password = password_hash($_SESSION['password'], PASSWORD_DEFAULT);

        $insertUser = "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$password')";
        if (mysqli_query($conn, $insertUser)) {
            echo "<div class='alert alert-success text-center mt-3'>Verification successful! Redirecting to login...</div>";
            session_destroy();
            header("Refresh:2; url=login.php");
            exit();
        } else {
            echo "<div class='alert alert-danger text-center'>Error: " . mysqli_error($conn) . "</div>";
        }
        mysqli_close($conn);
    } else {
        echo "<div class='alert alert-danger text-center mt-3'>Invalid OTP. Please try again.</div>";
    }
}
?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
