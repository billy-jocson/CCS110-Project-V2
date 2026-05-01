<?php
header('Content-Type: application/json');
session_start();
include('../../backend/database.php');

// Validate session and employee ID
if (!isset($_SESSION['employeeId'])) {
    echo json_encode(["status" => "error", "msg" => "Session expired. Please log in again."]);
    exit;
}

$employeeId = $_SESSION['employeeId'];
$letterOfIntent = htmlspecialchars($_POST['letterOfIntent'] ?? '');
$requestDate = $_POST['requestDate'] ?? date('Y-m-d');
$desiredDate = $_POST['desiredDate'] ?? '';

// Validation
if (empty($letterOfIntent) || strlen($letterOfIntent) < 20) {
    echo json_encode(["status" => "error", "msg" => "Resignation letter must be at least 20 characters long."]);
    exit;
}

if (empty($desiredDate)) {
    echo json_encode(["status" => "error", "msg" => "Desired resignation date is required."]);
    exit;
}

// Check if desired date is at least 30 days from now
$minDate = new DateTime();
$minDate->modify('+30 days');
$desiredDateTime = new DateTime($desiredDate);

if ($desiredDateTime < $minDate) {
    echo json_encode(["status" => "error", "msg" => "Desired resignation date must be at least 30 days from today."]);
    exit;
}

// Check if employee already has a pending resignation request
$checkStmt = $conn->prepare("SELECT resign_id FROM resignation_request WHERE employee_id = ? AND status = 0");
$checkStmt->bind_param('i', $employeeId);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    echo json_encode(["status" => "error", "msg" => "You already have a pending resignation request. Please wait for it to be reviewed."]);
    exit;
}

// Insert resignation request
$stmt = $conn->prepare("INSERT INTO resignation_request (employee_id, resignation_letter, request_date, desired_date, status) VALUES (?, ?, ?, ?, 0)");

if (!$stmt) {
    echo json_encode(["status" => "error", "msg" => "Database error: " . $conn->error]);
    exit;
}

$stmt->bind_param('isss', $employeeId, $letterOfIntent, $requestDate, $desiredDate);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "msg" => "Your resignation request has been submitted successfully. It will be reviewed by the HR department."]);
} else {
    echo json_encode(["status" => "error", "msg" => "Failed to submit resignation request. Please try again."]);
}

$stmt->close();
$conn->close();
?>