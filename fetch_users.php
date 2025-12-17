<?php
session_start();
if ($_SESSION['user']['role'] != 'admin') {
    header("Location: index.php");
    exit;
}
include 'functions.php';

require_once "config.php";
$start  = isset($_POST['start']) ? (int)$_POST['start'] : 0;
$length = isset($_POST['length']) ? (int)$_POST['length'] : 10;
$draw   = isset($_POST['draw']) ? (int)$_POST['draw'] : 0;




$sql = "SELECT * FROM users where 1=1";
if (isset($_POST['filters'])) {
    applyFilters($sql, $_POST['filters']);
}

$resultFiltered = $conn->query($sql);
$recordsFiltered = $resultFiltered->num_rows;

$sql .= " ORDER BY id ASC LIMIT $start, $length";

$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$recordsTotal = $conn->query("SELECT COUNT(*) FROM users")->fetch_row()[0];

echo json_encode([
    "draw" => $draw,
    "recordsTotal" => $recordsTotal,
    "recordsFiltered" => $recordsFiltered,
    "data" => $data
]);

