<?php
include '../../backend/database.php';
header('Content-Type: application/json');
$body = json_decode(file_get_contents('php://input'), true);
$deptId = $body['dept_id'];

$sql = "SELECT * FROM positions p WHERE p.dept_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $deptId);
$stmt->execute();

$positions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
echo json_encode($positions);
?>