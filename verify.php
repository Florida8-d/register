<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_code = trim($_POST['code']);

    if (isset($_SESSION['verification_code']) && isset($_SESSION['register_data'])) {

        if ($entered_code == $_SESSION['verification_code']) {
            $data = $_SESSION['register_data'];


            unset($_SESSION['verification_code']);

            header("Location:index.php");

            exit();
        } else {
            echo "<p style='color:red;'>Incorrect verification code!</p>";
        }

    } else {
        echo "<p style='color:red;'>Session expired! Please register again.</p>";
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
        <input type="text" name="code" class="form-control" placeholder="Enter verification code" style="margin-top: 180;" required>
        <button type="submit" class="btn btn-primary block full-width m-b" style="margin-top:34px;">Verify</button>
    </form>
</div>

</body>
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.js"></script>
</html>