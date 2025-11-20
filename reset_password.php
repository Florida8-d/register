<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = trim($_POST['code']);
    $new_password = $_POST['new_password'];

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

    $stmt = $conn->prepare("UPDATE user SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashed_password, $email);
    $stmt->execute();
    $stmt->close();

    unset($_SESSION['reset_code']);
    unset($_SESSION['reset_email']);

    echo "Password successfully reset! You can now <a href='inspinia-master/HTML5_Full_Version/login.html'>login</a>.";
}
?>

<form action="reset_password.php" method="post">
    <input type="text" name="code" placeholder="Enter reset code" required>
    <input type="password" name="new_password" placeholder="Enter new password" required>
    <button type="submit">Reset Password</button>
</form>

