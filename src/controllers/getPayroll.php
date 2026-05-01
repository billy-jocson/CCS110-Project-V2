<?php
include('../../backend/database.php');
session_start();
$id = $_SESSION['employeeId'];
header('Content-Type: application/json');
$mysql = mysqli_query($conn, "SELECT s.employee_id,concat( e.first_name, ' ', e.last_name ) AS full_name, s.base_pay, s.bonus, s.deduction, s.is_available,u.profile_link FROM employees AS e INNER JOIN salary_structure AS s ON s.employee_id = e.employee_id INNER JOIN users AS u ON u.user_id = e.user_id WHERE e.is_resigned = 0 AND e.employee_id != $id");

$data = [];
while ($row = mysqli_fetch_assoc($mysql)) {
    if (date("d") == 15) {
        $update = mysqli_query($conn, "update salary_structure set is_available = 1 where employee_id = {$row['employee_id']} and is_available = 0");
    }
    $data[] = $row;
}
echo json_encode($data);

?>