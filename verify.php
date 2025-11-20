<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_code = trim($_POST['code']);

    if (isset($_SESSION['verification_code']) && isset($_SESSION['register_data'])) {

        if ($entered_code == $_SESSION['verification_code']) {
            $data = $_SESSION['register_data'];


            unset($_SESSION['verification_code']);

            header("Location:index.html");

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

    <link href="inspinia-master/HTML5_Full_Version/css/bootstrap.min.css" rel="stylesheet">
    <link href="inspinia-master/HTML5_Full_Version/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="inspinia-master/HTML5_Full_Version/css/animate.css" rel="stylesheet">
    <link href="inspinia-master/HTML5_Full_Version/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

<div class="middle-box text-center loginscreen animated fadeInDown">
<form method="post">
    <input type="text" name="code" placeholder="Enter verification code" required>
    <button type="submit">Verify</button>
</form>
</div>
</body>
<script src="inspinia-master/HTML5_Full_Version/js/jquery-3.1.1.min.js"></script>
<script src="inspinia-master/HTML5_Full_Version/js/popper.min.js"></script>
<script src="inspinia-master/HTML5_Full_Version/js/bootstrap.js"></script>
</html>