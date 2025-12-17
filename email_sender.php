<?php

use PHPMailer\PHPMailer\PHPMailer;


require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';


function sendEmail($toEmail,$verification_code)
{

    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;

    $mail->Username = 'florartflorart88@gmail.com';
    $mail->Password = 'dfsc lkgb tjrx aayc';

    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('florartflorart88@gmail.com', 'Florart');
    $mail->addAddress($toEmail);

    $mail->isHTML(true);
    $mail->Subject = 'Verification Code';
    $mail->Body = 'Your verification code is: <b>' . $verification_code . '</b>';

    $mail->send();

}

