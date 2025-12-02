<?php
session_start();
require_once "config.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo "<script>alert('Please fill in all fields');</script>";
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows) {

        $user = $result->fetch_assoc();

        if (!password_verify($password, $user['password'])) {
            echo "<script>alert('Invalid email or password');</script>";
            exit;
        }

        if ($user['email_verified'] == 0) {

            $verification_code = rand(100000, 999999);

            $_SESSION['verification_code'] = $verification_code;
            $_SESSION['verify_email'] = $email;

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'florartflorart88@gmail.com';
                $mail->Password = 'dfsc lkgb tjrx aayc';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->setFrom('florartflorart88@gmail.com', 'Florart');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Verify your email';
                $mail->Body = "Your verification code is: <b>$verification_code</b>";
                $mail->send();

                header("Location: verify.php");
                exit;

            } catch (Exception $e) {
                echo "Email could not be sent. Error: {$mail->ErrorInfo}";
                exit;
            }
        }

        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $email,
            'role' => $user['role']
        ];

        if ($user['role'] === 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: index.php");
        }
        exit;
    }

    echo "<script>alert('Invalid email or password');</script>";
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

