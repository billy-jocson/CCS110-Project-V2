<?php
include('../backend/database.php');
if (isset($_POST['createAccount']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $department = $_POST['department'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $contact = $_POST['phone'];
    $position = $_POST['position'];

    $targetDir = "../assets/images/userProfiles/";

    $username = $_POST['username'];
    $password = $_POST['password'];
    $isAdmin = 0;
    $hash = password_hash($password, PASSWORD_DEFAULT);

    if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] == 0) {
        $pfp = basename($_FILES['profilePicture']['name']);
        $targetPath = $targetDir . $pfp;

        if (move_uploaded_file($_FILES['profilePicture']['tmp_name'], $targetPath)) {
            $stmt1 = $conn->prepare('INSERT INTO users (user_name, password, profile_link, is_admin) VALUES (?, ?, ?, ?)');
            $stmt1->bind_param('sssi', $username, $hash, $targetPath, $isAdmin);
            $stmt1->execute();

            $newUserId = $conn->insert_id;

            $stmt2 = $conn->prepare('INSERT INTO employees (dept_id, user_id, first_name, last_name, contact_no, position) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt2->bind_param('iissss', $department, $newUserId, $firstName, $lastName, $contact, $position);
            $stmt2->execute();

            $newEmployeeId = $conn->insert_id;

            $stmt3 = $conn->prepare('INSERT INTO salary_structure (position_id, employee_id, base_pay, bonus, deduction, is_available) VALUES (?, ?, (SELECT base_pay FROM position_salary WHERE position_id = ?), 0, 0, 0)');
            $stmt3->bind_param('iii', $position, $newEmployeeId, $position);
            $stmt3->execute();

            header('../login.php');
        }
    }
}
?>