<?php
session_start();
if ($_SESSION['user']['role'] != 'admin') {
    header("Location: index.php");
    exit;
}


require_once "config.php";

$start = isset($_POST['start']) ? (int)$_POST['start'] : 0;
$length = isset($_POST['length']) ? (int)$_POST['length'] : 10;
$draw = isset($_POST['draw']) ? (int)$_POST['draw'] : 0;

$stmt = $conn->prepare("SELECT * FROM users ORDER BY id ASC LIMIT ?, ?");
$stmt->bind_param("ii", $start, $length);
$stmt->execute();
$result = $stmt->get_result();

$user = [];
while ($row = $result->fetch_assoc()) {
    $user[] = $row;
}

$total = $conn->query("SELECT COUNT(*) FROM users")->fetch_row()[0];

echo json_encode([
    "draw" => $draw,
    "recordsTotal" => $total,
    "recordsFiltered" => $total,
    "data" => $user
]);
