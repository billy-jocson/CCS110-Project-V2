<?php
include('../../backend/database.php');
header('Content-Type: application/json');

$employeeId = $_POST['employee_id'] ?? null;

if (!$employeeId) {
    echo json_encode(['status' => 'error', 'msg' => 'Missing employee ID']);
    exit;
}

// Soft delete — mark as resigned instead of hard delete
$stmt = $conn->prepare("UPDATE employees SET is_resigned = 1 WHERE employee_id = ?");
$stmt->bind_param('i', $employeeId);
$stmt->execute();

echo json_encode(['status' => 'success', 'msg' => 'Employee removed']);
?>
