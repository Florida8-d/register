<?php
session_start();
require_once "config.php";
require_once "functions.php";
require_once "email_sender.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    trimArrayParams($_POST);
    $errors = [];

    if (empty($_POST['email']) || empty($_POST['password'])) {
        $errors['email'] = "Please fill in all fields.";
    } else {

        $stmt = $conn->prepare("SELECT id, password, role, email_verified FROM users WHERE email = ?");
        $stmt->bind_param("s", $_POST['email']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();

            if (!password_verify($_POST['password'], $user['password'])) {
                $errors['password'] = "Invalid email or password.";
            } else {

                if ($user['email_verified'] == 0) {

                    $verification_code = random();

                    $_SESSION['verification_code'] = $verification_code;
                    $_SESSION['user_id'] = $user['id'];

                    sendEmail($_POST['email'], $verification_code);
                    //mbishkrimi i kodit te ri
                    $stmt = $conn->prepare("INSERT INTO `users` (verificationCode) VALUES (?)");



                    header("Location: verify.php");
                    exit;
                } else {
                    $_SESSION['user'] = ['id' => $user['id'], 'role' => $user['role']];

                    if ($user['role'] === 'admin') {
                        header("Location: admin_dashboard.php");
                    } else {
                        header("Location: index.php");
                    }
                    exit;
                }
            }

        }
    }
}
?>

<!DOCTYPE html>
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

<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        <div>

        </div>


        <form class="m-t" role="form" action="login.php" method="post">


            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="E-mail" required="">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password" required="">
            </div>


            <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
            <a href="forgot_password.php"><small>Forgot password?</small></a>
            <p class="text-muted text-center"><small>Do not have an account?</small></p>
            <a class="btn btn-sm btn-white btn-block" href="register.php">Create an account</a>
        </form>

    </div>
</div>

<!-- Mainly scripts -->
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.js"></script>

</body>

</html>

