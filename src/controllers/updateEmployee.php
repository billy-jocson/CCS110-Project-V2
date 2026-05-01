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

// 1. Update employees table
$stmt = $conn->prepare("
    UPDATE employees 
    SET first_name = ?, last_name = ?, contact_no = ?, dept_id = ?, position = ?
    WHERE employee_id = ?
");
$stmt->bind_param('sssiii', $firstName, $lastName, $contact, $deptId, $positionId, $employeeId);
$stmt->execute();

// 2. Update is_admin flag — use == (loose) because $_POST values are strings
$isAdmin = ($deptId == 1) ? 1 : 0;
$stmt2 = $conn->prepare("UPDATE users SET is_admin = ? WHERE user_id = ?");
$stmt2->bind_param('ii', $isAdmin, $userId);  // use $userId not $employeeId
$stmt2->execute();

// 3. Fetch base_pay from position_salary, then update salary_structure
$stmt3a = $conn->prepare("SELECT base_pay FROM position_salary WHERE position_id = ?");
$stmt3a->bind_param('i', $positionId);
$stmt3a->execute();
$result = $stmt3a->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $basePay = $row['base_pay'];

    $stmt3b = $conn->prepare("
        UPDATE salary_structure 
        SET position_id = ?, base_pay = ?
        WHERE employee_id = ?
    ");
    $stmt3b->bind_param('idi', $positionId, $basePay, $employeeId);
    $stmt3b->execute();
} else {
    // No salary defined for this position — update position_id only
    $stmt3b = $conn->prepare("UPDATE salary_structure SET position_id = ? WHERE employee_id = ?");
    $stmt3b->bind_param('ii', $positionId, $employeeId);
    $stmt3b->execute();
}

// 4. Update username (and password if provided)
if (!empty($password)) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt4 = $conn->prepare("UPDATE users SET user_name = ?, password = ? WHERE user_id = ?");
    $stmt4->bind_param('ssi', $username, $hash, $userId);
} else {
    $stmt4 = $conn->prepare("UPDATE users SET user_name = ? WHERE user_id = ?");
    $stmt4->bind_param('si', $username, $userId);
}
$stmt4->execute();

// 5. Profile picture upload
if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] == 0) {
    $targetDir = "../../assets/images/userProfiles/";
    $pfp = basename($_FILES['profilePicture']['name']);
    $targetPath = $targetDir . $pfp;
    if (move_uploaded_file($_FILES['profilePicture']['tmp_name'], $targetPath)) {
        $profileLink = "../assets/images/userProfiles/" . $pfp;
        $stmt5 = $conn->prepare("UPDATE users SET profile_link = ? WHERE user_id = ?");
        $stmt5->bind_param('si', $profileLink, $userId);
        $stmt5->execute();
    }
}

echo json_encode(['status' => 'success', 'msg' => 'Employee updated']);
?>