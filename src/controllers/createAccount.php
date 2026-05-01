<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('../../backend/database.php');
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $department = (int) $_POST['department'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $contact = $_POST['phone'];
    $position = (int) $_POST['position'];
    $username = $_POST['username'];
    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $isAdmin = 0;

    // HR check — compare fully lowercased
    $deptCheck = $conn->prepare('SELECT dept_name FROM departments WHERE dept_id = ?');
    $deptCheck->bind_param('i', $department);
    $deptCheck->execute();
    $deptResult = $deptCheck->get_result()->fetch_assoc();
    if ($deptResult && $deptResult['dept_name'] == 'Human Resources') {
        $isAdmin = 1;
    }

    // Default picture, overwritten if upload succeeds
    $targetPath = '../assets/images/DefaultPFP.png';
    if (isset($_FILES['profilePicture']['name']) && $_FILES['profilePicture']['error'] === 0) {
        $pfp = basename($_FILES['profilePicture']['name']);
        $targetPath = '../assets/images/userProfiles/' . $pfp;
        move_uploaded_file($_FILES['profilePicture']['tmp_name'], $targetPath);
    }

    $stmt1 = $conn->prepare('INSERT INTO users (user_name, password, profile_link, is_admin) VALUES (?, ?, ?, ?)');
    $stmt1->bind_param('sssi', $username, $hash, $targetPath, $isAdmin);
    $stmt1->execute();
    $newUserId = $conn->insert_id;

    $stmt2 = $conn->prepare('INSERT INTO employees (dept_id, user_id, first_name, last_name, contact_no, position, is_resigned) VALUES (?, ?, ?, ?, ?, ?, 0)');
    $stmt2->bind_param('iisssi', $department, $newUserId, $firstName, $lastName, $contact, $position);
    $stmt2->execute();
    $newEmployeeId = $conn->insert_id;

    $stmt3 = $conn->prepare('INSERT INTO salary_structure (position_id, employee_id, base_pay, bonus, deduction, is_available) VALUES (?, ?, (SELECT base_pay FROM position_salary WHERE position_id = ?), 0, 0, 0)');
    $stmt3->bind_param('iii', $position, $newEmployeeId, $position);
    $stmt3->execute();
}
?>