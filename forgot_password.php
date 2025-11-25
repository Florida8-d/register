<?php
session_start();
include 'config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        echo "<p style='color:red;'>Email not found!</p>";
        exit;
    }
    $stmt->close();

    $reset_code = rand(100000, 999999);

    $_SESSION['reset_code'] = $reset_code;
    $_SESSION['reset_email'] = $email;

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
        $mail->Subject = 'Password Reset Code';
        $mail->Body    = 'Your password reset code is: <b>' . $reset_code . '</b>';

        $mail->send();

        header("Location: reset_password.php");
        exit;

    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
        exit;
    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Forgot password</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

<div class="passwordBox animated fadeInDown">
    <div class="row">

        <div class="col-md-12">
            <div class="ibox-content">

                <h2 class="font-bold">Forgot password</h2>

                <p>
                    Enter your email address and your password will be reset and emailed to you.
                </p>

                <div class="row">

                    <div class="col-lg-12">
                        <form class="m-t" role="form" action="forgot_password.php" method="post">
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="Email address" required="">
                            </div>

                            <button type="submit" class="btn btn-primary block full-width m-b" href="reset_password.php">Send new password</button>

                        </form>
                     </div>
                </div>
            </div>
        </div>
    </div>
    <hr/>

</div>

</body>

</html>

