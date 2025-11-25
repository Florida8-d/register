<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

function sendEmail($toEmail, $subject, $bodyHtml) {
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
        $mail->addAddress($toEmail);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $bodyHtml;

        return $mail->send();

    } catch (Exception $e) {
        return false;
    }
}
