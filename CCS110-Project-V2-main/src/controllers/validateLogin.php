<?php
header('Content-Type: application/json');
include('../../backend/database.php');
$stmt = $conn->prepare("SELECT users.*, employees.employee_id, employees.is_resigned, employees.position, employees.first_name, employees.last_name
    FROM users
    LEFT JOIN employees ON users.user_id = employees.user_id
    WHERE users.user_name = ?
");

$stmt->bind_param('s', $_POST['username']);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if ($result && password_verify($_POST['password'], $result['password']) && $result['is_resigned'] == 0) {
    session_start();
    $_SESSION['fullName'] = "$result[first_name] $result[last_name]";
    $_SESSION['isAdmin'] = $result['is_admin'];
    $_SESSION['profileLink'] = $result['profile_link'];
    $_SESSION['position'] = $result['position'];
    $_SESSION['employeeId'] = $result['employee_id'];
    $adminStatus = 0;
    if ($_SESSION['isAdmin'] == 1) {
        $adminStatus = 1;
    }

    echo json_encode(["status" => "success", "msg" => "correct credentials", "isAdmin" => "$adminStatus"]);
} else {
    if ($result['is_resigned'] == 1) {
        echo json_encode(["status" => "error", "msg" => "Employee is already resigned."]);
    } else {
        echo json_encode(["status" => "error", "msg" => "Incorrect credentials!"]);
    }
}
?>