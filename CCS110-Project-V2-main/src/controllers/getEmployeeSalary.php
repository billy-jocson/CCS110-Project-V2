<?php
include('../../backend/database.php');
header('Content-Type: application/json');

$json = file_get_contents('php://input');
$data = json_decode($json, true);
$id = $data['id'];

$mysql = mysqli_query($conn, "select s.employee_id,u.user_name, concat( e.first_name, ' ', e.last_name ) as full_name, s.base_pay, s.bonus, s.deduction, s.is_available,p.position_name ,u.profile_link from employees as e inner join salary_structure as s on s.employee_id = e.employee_id inner join users as u on u.user_id = e.user_id inner join positions as p on p.position_id = e.position where e.is_resigned = 0 and s.employee_id = $id");

$user = mysqli_fetch_assoc($mysql);

echo json_encode([$user]);

?>