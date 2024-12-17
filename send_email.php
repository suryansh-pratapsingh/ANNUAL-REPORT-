<?php
session_start();

include "connection.php";
require "./PHPMailer-master/src/PHPMailer.php";
require "./PHPMailer-master/src/SMTP.php";
require "./PHPMailer-master/src/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

if ($password !== $confirm_password) {
    die("Passwords do not match!");
}

// Generate OTP
$otp = random_int(100000, 999999);

// Store user data in session
$_SESSION['username'] = $username;
$_SESSION['email'] = $email;
$_SESSION['password'] = $password;
$_SESSION['otp'] = $otp;

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = "tls";
$mail->Host = "smtp.gmail.com";
$mail->Port = 587;
$mail->Username = "yourEmailID@gmail.com";
$mail->Password = "Your Password";
$mail->setFrom("yourEmailID@gmail.com", "Annual Vision");
$mail->addAddress($email);
$mail->Subject = "OTP for Annual Vision Sign-Up";
$mail->Body = "Hi $username, your OTP for account verification is $otp.";
$mail->send();

header("Location: otp_verification.php");
?>
