<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $code = isset($_POST['code']) ? trim($_POST['code']) : null;
    $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : null;

    if (!$code || !$new_password) {
        echo "Please fill in all fields!";
        exit;
    }


    if (!isset($_SESSION['reset_code']) || !isset($_SESSION['reset_email'])) {
        echo "Session expired. Please try again.";
        exit;
    }

    if ($code != $_SESSION['reset_code']) {
        echo "Invalid code!";
        exit;
    }

    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $email = $_SESSION['reset_email'];

    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashed_password, $email);
    $stmt->execute();
    $stmt->close();

    unset($_SESSION['reset_code']);
    unset($_SESSION['reset_email']);

    echo "Password successfully reset! You can now <a href='login.php'>login</a>.";
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
    <div class="ibox-content">

        <h2 class="font-bold">Reset Password</h2>
        <p>Enter the code you received and your new password.</p>

        <form action="reset_password.php" method="post" class="m-t">
            <div class="form-group">
                <input class="form-control" type="text" name="code" placeholder="Enter reset code" required>
            </div>

            <div class="form-group">
                <input class="form-control" type="password" name="new_password" placeholder="Enter new password" required>
            </div>

            <button type="submit" class="btn btn-primary block full-width m-b" style="margin-top:10px;">
                Reset Password
            </button>
        </form>

    </div>
</div>
</body>
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.js"></script>
</html>



