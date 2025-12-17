<?php
session_start();
require_once "config.php";
require_once "functions.php";


if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    trimArrayParams($_POST);


    $errors = [];

    if (!isset($_SESSION['verification_code']) || $_POST['code'] != $_SESSION['verification_code']) {
        $errors['code'] = "Invalid or expired code.";
    }else{


        $stmt = $conn->prepare("UPDATE users SET email_verified = 1 WHERE email = ?");
        $stmt->bind_param("s", $SESSION['user_id']);
        $stmt->execute();
        $stmt->close();



        header("Location: index.php");
        exit;

    }

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
        <input type="text" name="code" id="code" class="form-control" placeholder="Enter verification code" style="margin-top: 180;" required>
        <button type="submit" class="btn btn-primary block full-width m-b" style="margin-top:34px;">Verify</button>
    </form>
</div>

</body>
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.js"></script>
</html>