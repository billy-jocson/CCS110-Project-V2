<?php
include("../../backend/database.php");
header('Content-Type: application/json');

$id     = $_POST["id"]     ?? null;
$choice = $_POST["choice"] ?? null;

if (!$id || !$choice) {
    echo json_encode(['status' => 'error', 'msg' => 'Missing parameters']);
    exit;
}

switch ($choice) {
    case 1:
        // Approve — update resignation status AND mark employee as resigned
        $conn->query("UPDATE resignation_request SET status = 1 WHERE resign_id = $id");
        $conn->query("UPDATE employees e
                      JOIN resignation_request r ON e.employee_id = r.employee_id
                      SET e.is_resigned = 1
                      WHERE r.resign_id = $id");
        echo json_encode(['status' => 'success', 'msg' => 'Resignation approved']);
        break;

    case 2:
        // Decline — just update resignation status
        $conn->query("UPDATE resignation_request SET status = 2 WHERE resign_id = $id");
        echo json_encode(['status' => 'success', 'msg' => 'Resignation declined']);
        break;

    default:
        echo json_encode(['status' => 'error', 'msg' => 'Invalid choice']);
}
?>
