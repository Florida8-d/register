<?php
session_start();
require_once "config.php";
require_once "functions.php";
require_once "email_sender.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    trimArrayParams($_POST);

    $errors = [];

    if (empty($_POST['name']) || !preg_match("/^[a-zA-Z]+$/", $_POST['name'])) {
        $errors['name'] = "Name is required and should contain only letters.";
    }
    if (empty($_POST['surname']) || !preg_match("/^[a-zA-Z]+$/", $_POST['surname'])) {
        $errors['surname'] = "Surname is required and should contain only letters.";
    }
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }
    $passValidator = validatePassword($_POST['password'], $_POST['confirmpassword']);
    if ($passValidator['status'] == false) {
        $errors['password'] = $passValidator['message'];
    }
    if (empty($_POST['birthday'])) {
        $errors['birthday'] = "Birthday is required";
    }

    $stmt = $conn->prepare("SELECT id FROM `users` WHERE email = ?");
    $stmt->bind_param("s", $_POST['email']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $errors['email'] = "This email is registered.Log-in";
    }

    $stmt->close();

    if (sizeof($errors) < 1) {
        $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $verification_code = random();

        $stmt = $conn->prepare("INSERT INTO `users` (name, surname, email, address, password, birthday,verificationCode) VALUES (?, ?, ?, ?, ?, ?,?)");
        $stmt->bind_param("sssssss", $_POST['name'], $_POST['surname'], $_POST['email'], $_POST['address'], $hashed_password, $_POST['birthday'], $verification_code);
        $stmt->execute();
        $lastId = $conn->insert_id;
        $stmt->close();


        $_SESSION = array_merge($_SESSION, ['user' => $lastId, 'verification_code' => $verification_code, 'email' => $_POST['email'],]);


        sendEmail($_POST['email'], $verification_code);

        header("Location: verify.php");
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
                <input type="text" name="name" class="form-control" placeholder="Name" required
                       value="<?= @$_POST['name'] ?>">
                <?php if (!empty($errors['name'])) { ?>
                    <small style="color:red"><?php echo $errors['name']; ?></small>
                <?php } ?>
            </div>
            <div class="form-group">
                <input type="text" name="surname" class="form-control" placeholder="Surname" required
                       value="<?= @$_POST['surname'] ?>">
            </div>
            <?php if (!empty($errors['surname'])) { ?>
                <small style="color:red"><?php echo $errors['surname']; ?></small>
            <?php } ?>
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Email" required
                       value="<?= @$_POST['email'] ?>">
            </div>
            <?php if (!empty($errors['email'])) { ?>
                <small style="color:red"><?php echo $errors['email']; ?></small>
            <?php } ?>
            <div class="form-group">
                <input type="text" name="address" class="form-control" placeholder="Address" required
                       value="<?= @$_POST['address'] ?>">
            </div>
            <div class="form-group">
                <div class="input-group date">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text"
                                                                                                class="form-control"
                                                                                                value="03/04/2014"
                                                                                                name="birthday">
                </div>
            </div><?php if (!empty($errors['birthday'])) { ?>
                <small style="color:red"><?php echo $errors['birthday']; ?></small>
            <?php } ?>

            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password" required
                       value="<?= @$_POST['password'] ?>">
            </div><?php if (!empty($errors['password'])) { ?>
                <small style="color:red"><?php echo $errors['password']; ?></small>
            <?php } ?>
            <div class="form-group">
                <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password"
                       required value="<?= @$_POST['confirmpassword'] ?>">
            </div>
            <div class="form-group">
                <div class="checkbox i-checks"><label> <input required name="chackbox" type="checkbox"><i></i> Agree the
                        terms and policy </label></div>
            </div>
    </div>
    <button type="submit" class="btn btn-primary block full-width m-b" onsubmit="return checkCheckBoxes">Register
    </button>

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
    $(document).ready(function () {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });


        var yearsAgo = new Date();
        yearsAgo.setFullYear(yearsAgo.getFullYear() - 20);

        $('#selector').datepicker('setDate', yearsAgo);
        $('input[name="birthday"]').datepicker({
            startView: 1,
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true,
            format: "dd/mm/yyyy"
        });

        $('form').on('submit', function (e) {
            if (!validateNameSurname() || !validateNumber() || !validateCheckbox()) {
                e.preventDefault();
            }
        });
    });
</script>

</body>


</html>

