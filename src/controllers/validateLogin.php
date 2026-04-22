<?php
session_start();
include('../../backend/database.php');
$stmt = $conn->prepare('
    SELECT users.*, employees.position, employees.first_name, employees.last_name, employees.employee_id
    FROM users
    LEFT JOIN employees ON users.user_id = employees.user_id
    WHERE users.user_name = ? AND employees.is_resigned = false
');

$stmt->bind_param('s', $_POST['username']);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if ($result && password_verify($_POST['password'], $result['password'])) {
    unset($_SESSION['username'], $_SESSION['password']);
    session_start();
     $_SESSION['employee_id'] = $result['employee_id'];
    $_SESSION['fullName'] = "$result[first_name] $result[last_name]";
    $_SESSION['isAdmin'] = $result['is_admin'];
    $_SESSION['profileLink'] = $result['profile_link'];
    $_SESSION['position'] = $result['position'];
    $_SESSION['is_paid'] = $result['is_paid'];

    if ($result['is_admin'] == 0) {
        header("Location: ../../pages/employeesDashboard.php"); // change to employee dashboard later
    } else {
        header("Location: ../../pages/adminDashboard.php");
    }
    exit();
} else {
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['password'] = $_POST['password'];
    header("Location: ../../login.php?invalid=1");
    exit();
}
?>