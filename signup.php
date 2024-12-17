<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up - Annual Vision</title>
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
        <h2 class="text-center mb-4" id="su">Sign Up</h2>
        <div class="card p-4 shadow">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" id="username" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" required 
                        pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{10,}$"
                        title="Password must be at least 10 characters long, include uppercase and lowercase letters, a number, and a symbol.">
                    <small class="form-text text-muted">Password must be at least 10 characters long, contain uppercase and lowercase letters, a number, and a symbol.</small>
                </div>
                <div class="mb-3">
                    <label for="confirm-password" class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" id="confirm-password" required>
                </div>
                <button type="submit" name="signup" class="btn btn-primary">Sign Up</button>
            </form>
            <div class="text-center mt-3">
                <a href="login.php">Already have an account? Log in here</a>
            </div>
        </div>
    </div>
    <?php
session_start();  // Start the session at the very beginning

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer
require "./PHPMailer/PHPMailer-master/src/PHPMailer.php";
require "./PHPMailer/PHPMailer-master/src/Exception.php";
require "./PHPMailer/PHPMailer-master/src/SMTP.php";

if (isset($_POST['signup'])) {
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $database = "tut";

    $conn = mysqli_connect($servername, $db_username, $db_password, $database);
    if (!$conn) {
        die("<div class='alert alert-danger text-center'>Connection failed: " . mysqli_connect_error() . "</div>");
    }

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo "<div class='alert alert-danger text-center mt-3'>Passwords do not match. Please try again.</div>";
    } else {
        $checkUser = "SELECT * FROM user WHERE username='$username' OR email='$email'";
        $result = mysqli_query($conn, $checkUser);

        if (mysqli_num_rows($result) > 0) {
            echo "<div class='alert alert-danger text-center mt-3'>Username or Email already exists. Please try again.</div>";
        } else {
            // Generate OTP
            $otp = random_int(100000, 999999);
            $_SESSION['otp'] = $otp;
            $_SESSION['email'] = $email;
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;

            // Send OTP via Email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'aceofthrones@gmail.com'; // Replace with your email
                $mail->Password = 'kbeg qkvh anmk xhcr'; // Replace with your email password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('yourEmail@gmail.com', 'Annual Vision');
                $mail->addAddress($email);
                $mail->Subject = 'Your OTP for Annual Vision';
                $mail->Body = "Hi $username,\n\nYour OTP for signing up is: $otp.\n\nPlease verify it within 10 minutes.";

                $mail->send();
                header("Location: otp_verification.php");
                exit();
            } catch (Exception $e) {
                echo "<div class='alert alert-danger text-center mt-3'>Error: Unable to send OTP. Please try again later.</div>";
            }
        }
    }
    mysqli_close($conn);
}
?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
