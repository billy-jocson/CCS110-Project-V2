<?php
include '../../backend/database.php';
header('Content-Type: application/json');

$sql = "SELECT * FROM departments";
$stmt = $conn->prepare($sql);
$stmt->execute();

$departments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
echo json_encode($departments);
?>