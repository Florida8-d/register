<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_code = trim($_POST['code']);

    if (!isset($_SESSION['verification_code'])) {
        echo "<p style='color:red;'>Session expired! Please try again.</p>";
        exit;
    }

    if ($entered_code != $_SESSION['verification_code']) {
        echo "<p style='color:red;'>Incorrect verification code!</p>";
        exit;
    }

    if (isset($_SESSION['register_data'])) {

        $data = $_SESSION['register_data'];

        $stmt = $conn->prepare("UPDATE users SET email_verified = 1 WHERE email = ?");
        $stmt->bind_param("s", $data['email']);
        $stmt->execute();

        unset($_SESSION['register_data']);
        unset($_SESSION['verification_code']);

        echo "<script>alert('Email verified! You can now login.'); window.location='login.php';</script>";
        exit;
    }

    if (isset($_SESSION['verify_email'])) {

        $email = $_SESSION['verify_email'];


        $stmt = $conn->prepare("UPDATE users SET email_verified = 1 WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();


        unset($_SESSION['verify_email']);
        unset($_SESSION['verification_code']);

        echo "<script>alert('Email verified! Logging you in...'); window.location='login.php';</script>";
        exit;
    }

    echo "<p style='color:red;'>Session expired! Try again.</p>";
    exit;
}
?>

<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

<div class="middle-box text-center loginscreen animated fadeInDown form-group"">
    <form method="post">
        <input type="text" name="code" class="form-control" placeholder="Enter verification code" style="margin-top: 180;" required>
        <button type="submit" class="btn btn-primary block full-width m-b" style="margin-top:34px;">Verify</button>
    </form>
</div>

</body>
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.js"></script>
</html>