<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Faculty Login - Annual Vision</title>
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

        #r{
            color : white;
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
                <a href="signup.php" class="btn btn-outline-light">Sign Up</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-4" id="su">Faculty Login</h2>
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
                <button type="submit" name="login" class="btn btn-primary">Login</button>
            </form>
            <div class="text-center mt-3">
                <a href="signup.php">Don't have an account? Sign up here</a>
            </div>
        </div>

        <!-- Link to student login page -->
        <div class="text-center mt-3">
            <a id = "r" href="student_login.php">Login as Student</a>
        </div>
    </div>

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

        $checkUser = "SELECT * FROM user WHERE username='$username'";
        $result = mysqli_query($conn, $checkUser);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) { // Verify hashed password
                $login = true;
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                header("Location: dashboard.php");
                exit();
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
