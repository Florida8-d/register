<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

require_once "config.php";

$records_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;


$offset = ($page - 1) * $records_per_page;

$stmt = $conn->prepare("SELECT * FROM users ORDER BY id ASC LIMIT ?, ?");
$stmt->bind_param("ii", $offset, $records_per_page);
$stmt->execute();
$result = $stmt->get_result();

$user = [];
while ($row = $result->fetch_assoc()) {
    $user[] = $row;
}


echo json_encode(['data' => $user]);
