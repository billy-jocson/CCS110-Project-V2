<?php
include('../../backend/database.php');
header('Content-Type: application/json');

$toSearch = $_POST['toSearch'] ?? '';
$searchTerm = "%$toSearch%";

$query = "
    SELECT 
        e.employee_id, 
        e.first_name, 
        e.last_name, 
        d.dept_name 
    FROM employees e
    LEFT JOIN departments d ON e.dept_id = d.dept_id
    WHERE e.first_name LIKE ? 
       OR e.last_name LIKE ? 
       OR e.employee_id LIKE ? 
       OR d.dept_name LIKE ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("ssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm);
$stmt->execute();

$employees = [];

while ($emp = $stmt->fetch(PDO::FETCH_OBJ)) {
    $employees[] = [
        'id' => $emp->employee_id,
        'full_name' => $emp->first_name . ' ' . $emp->last_name,
        'dept' => $emp->dept_name
    ];
}

echo json_encode($employees);
?>