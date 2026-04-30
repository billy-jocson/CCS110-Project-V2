<?php
include('../../backend/database.php');
header('Content-Type: application/json');

$sql = "
    SELECT 
        e.employee_id,
        e.dept_id,
        e.first_name,
        e.last_name,
        e.contact_no,
        p.position_name,
        p.position_id,
        d.dept_name,
        d.dept_code,
        u.profile_link
    FROM employees e
    LEFT JOIN users u ON e.user_id = u.user_id
    LEFT JOIN positions p ON e.position = p.position_id
    LEFT JOIN departments d ON e.dept_id = d.dept_id
    WHERE e.is_resigned = 0
    ORDER BY e.employee_id ASC
";

$result = $conn->query($sql);
$employees = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($employees);
?>