<?php

session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

require_once "config.php";

$user = [];
$sql = "SELECT id, name, surname, email, number, adress, role, birthday FROM user";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $user[] = $row;
}

echo json_encode(['data' => $user]);

