login 



<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Annual Vision</title>
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
                <a href="signup.php" class="btn btn-outline-light">Sign Up</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-4" id="su">Login</h2>
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

        $checkUser = "SELECT * FROM user WHERE username='$username' AND password='$password'";
        $result = mysqli_query($conn, $checkUser);

        if (mysqli_num_rows($result) === 1) {
            $login = true;
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<div class='alert alert-danger text-center mt-3'>Incorrect username or password.</div>";
        }
        mysqli_close($conn);
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

sign-up 

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
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                </div>
                <button type="submit" name="signup" class="btn btn-primary">Sign Up</button>
            </form>
            <div class="text-center mt-3">
                <a href="login.php">Already have an account? Log in here</a>
            </div>
        </div>
    </div>

    <?php
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
        $password = $_POST['password'];

        $checkUser = "SELECT * FROM user WHERE username='$username'";
        $result = mysqli_query($conn, $checkUser);

        if (mysqli_num_rows($result) > 0) {
            echo "<div class='alert alert-danger text-center mt-3'>Username already exists. Please choose another one.</div>";
        } else {
            $insertUser = "INSERT INTO user (username, password) VALUES ('$username', '$password')";
            if (mysqli_query($conn, $insertUser)) {
                echo "<div class='alert alert-success text-center mt-3'>Registration successful! You can <a href='login.php'>log in here</a>.</div>";
            } else {
                echo "<div class='alert alert-danger text-center mt-3'>Error: " . mysqli_error($conn) . "</div>";
            }
        }
        mysqli_close($conn);
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

data input 

<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $database = "tut";

    $conn = mysqli_connect($servername, $db_username, $db_password, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $department_name = $_POST['department_name'];
    $year_of_class = $_POST['year_of_class'];
    $section = $_POST['section'];

    $sql_class = "INSERT INTO class_details (department_name, year_of_class, section) VALUES ('$department_name', $year_of_class, '$section')";
    if (mysqli_query($conn, $sql_class)) {
        $class_id = mysqli_insert_id($conn);

        if (isset($_FILES['student_file']) && $_FILES['student_file']['error'] == 0) {
            require_once 'PHPExcel.php';
            $inputFile = $_FILES['student_file']['tmp_name'];
            $objPHPExcel = PHPExcel_IOFactory::load($inputFile);

            foreach ($objPHPExcel->getActiveSheet()->getRowIterator() as $row) {
                $data = [];
                foreach ($row->getCellIterator() as $cell) {
                    $data[] = $cell->getValue();
                }

                $sql_student = "INSERT INTO students (enrollment_number, student_name, subject_code_1, subject_code_2, subject_code_3, subject_code_4, subject_code_5, attendance, extracurricular_activity, class_id) VALUES ('$data[0]', '$data[1]', $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], '$data[8]', $class_id)";
                mysqli_query($conn, $sql_student);
            }
            echo "<div class='alert alert-success text-center'>Data imported successfully.</div>";
        } else {
            echo "<div class='alert alert-danger text-center'>Error uploading file.</div>";
        }
    } else {
        echo "<div class='alert alert-danger text-center'>Error adding class details.</div>";
    }

    mysqli_close($conn);
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Import - Annual Vision</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background: #111;
        color: white;
        overflow: hidden;
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
            <a class="navbar-brand" href="dashboard.php"><img src="l.png" alt="Logo" width="30" height="30"
                    class="d-inline-block align-top"> Annual Vision</a>
            <div><a href="logout.php" class="btn btn-outline-light">Logout</a></div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Data Import</h2>
        <div class="card p-4 shadow">
            <form action="data_import.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="department_name" class="form-label">Department Name</label>
                    <input type="text" name="department_name" class="form-control" id="department_name" required>
                </div>
                <div class="mb-3">
                    <label for="year_of_class" class="form-label">Year of Class</label>
                    <input type="number" name="year_of_class" class="form-control" id="year_of_class" required>
                </div>
                <div class="mb-3">
                    <label for="section" class="form-label">Section</label>
                    <input type="text" name="section" class="form-control" id="section" required>
                </div>
                <div class="mb-3">
                    <label for="student_file" class="form-label">Student Data (Excel)</label>
                    <input type="file" name="student_file" class="form-control" id="student_file" accept=".xls,.xlsx"
                        required>
                </div>
                <button type="submit" class="btn btn-primary">Upload and Import Data</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>