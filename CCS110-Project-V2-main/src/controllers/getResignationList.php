<?php
include('../../backend/database.php');
header('Content-Type: application/json');

$sql = "
    SELECT 
        r.resign_id,
        r.employee_id,
        r.resignation_letter,
        r.request_date,
        r.desired_date,
        r.status,
        e.first_name,
        e.last_name,
        p.position_name,
        u.profile_link
    FROM resignation_request r
    LEFT JOIN employees e ON r.employee_id = e.employee_id
    LEFT JOIN positions p ON e.position = p.position_id
    LEFT JOIN users u ON e.user_id = u.user_id
    ORDER BY r.request_date DESC
";

$result = $conn->query($sql);
$requests = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($requests);
?>