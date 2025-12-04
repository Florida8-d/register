<?php
session_start();
require_once "config.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $birthday = trim($_POST['birthday']);
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];




    $errors = [];

    if ($password !== $confirmpassword) {
        $errors[] = "Passwords do not match.";
    }


    if (empty($name) || !preg_match("/^[a-zA-Z]+$/", $name)) {
        $errors[] = "Name is required and should contain only letters.";
    }
    if (empty($surname) || !preg_match("/^[a-zA-Z]+$/", $surname)) {
        $errors[] = "Surname is required and should contain only letters.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters.";
    }
    if (empty($birthday)) {
        $errors[] = "Birthday is required";
    }


    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
        exit;
    }

    $stmt = $conn->prepare("SELECT id FROM `users` WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<p style='color:red;'>This email is already registered.</p>";
        exit;
    }
    $stmt->close();

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO `users` (name, surname, email, address, password, birthday) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $surname, $email, $address, $hashed_password, $birthday);
    $stmt->execute();
    $stmt->close();





    $verification_code = rand(100000, 999999);


    $_SESSION['verification_code'] = $verification_code;
    $_SESSION['register_data'] = [
        'name' => $name,
        'surname' => $surname,
        'email' => $email,
        'address' => $address,
        'password' => $hashed_password,
        'birthday' => $birthday

    ];


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
        $mail->Subject = 'Verification Code';
        $mail->Body    = 'Your verification code is: <b>' . $verification_code . '</b>';

        $mail->send();

        header("Location: verify.php");
        exit;

    } catch (Exception $e) {
        echo "<p style='color:red;'>Mailer Error: {$mail->ErrorInfo}</p>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">

    <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">

    <link href="css/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">


    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>
<body class="gray-bg">

<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        <h3 class="tittle">Register form</h3>

        <form action="register.php" method="post">

            <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Name" required>
            </div>
            <div class="form-group">
                <input type="text" name="surname" class="form-control" placeholder="Surname" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="text" name="address" class="form-control" placeholder="Address" required>
            </div>
            <div class="form-group">
                <div class="input-group date">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="03/04/2014" name="birthday">
                </div>
            </div>

            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password" required>
            </div>
            <div class="form-group">
                <div class="checkbox i-checks"><label> <input required name="chackbox" type="checkbox"><i></i> Agree the terms and policy </label></div>
            </div>
    </div>
    <button type="submit" class="btn btn-primary block full-width m-b"  onsubmit="return checkCheckBoxes">Register</button>

    <p class="text-muted text-center"><small>Already have an account?</small></p>
    <a class="btn btn-sm btn-white btn-block" href="login.php">Login</a>
    </form>
</div>
</div>

<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.js"></script>



<!-- Data picker -->
<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>


<script src="js/plugins/iCheck/icheck.min.js"></script>

<!-- Color picker -->
<script src="js/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>

<!-- Clock picker -->
<script src="js/plugins/clockpicker/clockpicker.js"></script>

<!-- Date range use moment.js same as full calendar plugin -->
<script src="js/plugins/fullcalendar/moment.min.js"></script>
<!-- Date range picker -->
<script src="js/plugins/daterangepicker/daterangepicker.js"></script>



<script>
    $(document).ready(function(){
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

        function checkCheckBoxes(theForm) {
            if (
                theForm.MyCheckbox.checked == false)
            {
                alert ('You didn\'t choose any of the checkboxes!');
                return false;
            } else {
                return true;
            }
        }

        var yearsAgo = new Date();
        yearsAgo.setFullYear(yearsAgo.getFullYear() - 20);

        $('#selector').datepicker('setDate', yearsAgo );
        $('input[name="birthday"]').datepicker({
            startView: 1,
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true,
            format: "dd/mm/yyyy"       });


        function validateNameSurname() {
            const name = document.querySelector('input[name="name"]').value.trim();
            const surname = document.querySelector('input[name="surname"]').value.trim();
            const regex = /^[A-Za-z]+$/;
            if (!regex.test(name) || !regex.test(surname)) {
                alert("Name or surname must contain only letters!");
                return false;
            }
            return true;
        }

        function validateNumber() {
            const numberInput = document.querySelector('input[name="number"]').value.trim();
            const regex1 = /^[0-9]{9,15}$/;
            if (!regex1.test(numberInput)) {
                alert("Please enter a valid phone number.");
                return false;
            }
            return true;
        }

        function validateCheckbox() {
            const checkbox = document.querySelector('.i-checks input[type="checkbox"]');
            if (!checkbox.checked) {
                alert("You must agree to the terms and policy before registering.");
                return false;
            }
            return true;
        }

        $('form').on('submit', function(e) {
            if (!validateNameSurname() || !validateNumber() || !validateCheckbox()) {
                e.preventDefault();
            }
        });
    });
</script>


</body>


</html>

