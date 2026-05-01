<?php
include('../../backend/database.php');
header('Content-Type: application/json');
$mysql = mysqli_query($conn, "select s.employee_id,concat( e.first_name, ' ', e.last_name ) as full_name, s.base_pay, s.bonus, s.deduction, s.is_available,u.profile_link from employees as e inner join salary_structure as s on s.employee_id = e.employee_id inner join users as u on u.user_id = e.user_id where e.is_resigned = 0");

$data = [];
while ($row = mysqli_fetch_assoc($mysql)) {
    if (date("d") == 15) {
        $update = mysqli_query($conn, "update salary_structure set is_available = 1 where employee_id = {$row['employee_id']} and is_available = 0");
    }
    $data[] = $row;
}
echo json_encode($data);

?>