<?php
session_start();
require_once "config.php";

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

        if (password_verify($password, $user['password'])) {

            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $email,
                'role' => $user['role']
            ];

            if ($user['role'] === 'admin') {
                header("Location: admin_dashboard.php");
                exit;
            } else {
                header("Location: index.html");
                exit;
            }

        } else {
            echo "<script>alert('Invalid email or password');</script>";
        }
    } else {
        echo "<script>alert('Invalid email or password');</script>";
    }

    $stmt->close();
    $conn->close();
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

