<?php
include('../../backend/database.php');
header('Content-Type: application/json');

$employeeId = $_POST['employee_id'] ?? null;
$userId = $_POST['user_id'] ?? null;
$firstName = $_POST['firstName'] ?? null;
$lastName = $_POST['lastName'] ?? null;
$contact = $_POST['phone'] ?? null;
$deptId = $_POST['department'] ?? null;
$positionId = $_POST['position'] ?? null;
$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;

if (!$employeeId || !$userId) {
    echo json_encode(['status' => 'error', 'msg' => 'Missing required fields']);
    exit;
}

$stmt = $conn->prepare("
    UPDATE employees 
    SET first_name = ?, last_name = ?, contact_no = ?, dept_id = ?, position = ?
    WHERE employee_id = ?
");
$stmt->bind_param('sssiii', $firstName, $lastName, $contact, $deptId, $positionId, $employeeId);
$stmt->execute();

$stmt2 = $conn->prepare("
    UPDATE salary_structure 
    SET position_id = ?, base_pay = (SELECT base_pay FROM position_salary WHERE position_id = ?)
    WHERE employee_id = ?
");
$stmt2->bind_param('iii', $positionId, $positionId, $employeeId);
$stmt2->execute();

if (!empty($password)) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt2 = $conn->prepare("UPDATE users SET user_name = ?, password = ? WHERE user_id = ?");
    $stmt2->bind_param('ssi', $username, $hash, $userId);
    $stmt2->execute();
} else {
    $stmt2 = $conn->prepare("UPDATE users SET user_name = ? WHERE user_id = ?");
    $stmt2->bind_param('si', $username, $userId);
    $stmt2->execute();
}

if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] == 0) {
    $targetDir = "../../assets/images/userProfiles/";
    $pfp = basename($_FILES['profilePicture']['name']);
    $targetPath = $targetDir . $pfp;
    if (move_uploaded_file($_FILES['profilePicture']['tmp_name'], $targetPath)) {
        $profileLink = "../assets/images/userProfiles/" . $pfp;
        $stmt3 = $conn->prepare("UPDATE users SET profile_link = ? WHERE user_id = ?");
        $stmt3->bind_param('si', $profileLink, $userId);
        $stmt3->execute();
    }
}

echo json_encode(['status' => 'success', 'msg' => 'Employee updated']);
?>