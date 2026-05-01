<?php
include('../../backend/database.php');
header('Content-Type: application/json');

$employeeId = $_POST['employee_id'] ?? null;

if (!$employeeId) {
    echo json_encode(['status' => 'error', 'msg' => 'Missing employee ID']);
    exit;
}

$stmt1 = $conn->prepare("DELETE FROM salary_history WHERE employee_id = ?");
$stmt1->bind_param('i', $employeeId);
$stmt1->execute();

$stmt2 = $conn->prepare("DELETE FROM salary_structure WHERE employee_id = ?");
$stmt2->bind_param('i', $employeeId);
$stmt2->execute();

$stmt3 = $conn->prepare("DELETE FROM employees WHERE employee_id = ?");
$stmt3->bind_param('i', $employeeId);
$stmt3->execute();

$stmt4 = $conn->prepare("DELETE FROM users WHERE user_id = ?");
$stmt4->bind_param('i', $employeeId);
$stmt4->execute();

echo json_encode(['status' => 'success', 'msg' => 'Employee removed']);
?>