<?php
include('../../backend/database.php');
header("Content-Type: application/json");
$json = file_get_contents('php://input');
$data = json_decode($json, true);
$id = $data['id'];

mysqli_query($conn, "update salary_structure set is_available = 1 where employee_id = {$id}");

echo json_encode(["message" => "Success!"]);
?>