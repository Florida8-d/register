<?php

session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

require_once "config.php";

$user = [];
$sql = "SELECT id, name, surname, email, address, role, birthday,email_verified FROM users";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $user[] = $row;
}

echo json_encode(['data' => $user]);

