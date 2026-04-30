<<<<<<< HEAD
<?php
include('../../backend/database.php');
header('Content-Type: application/json');
$id = $_POST['id'];

$stmt = $conn->prepare("SELECT employees.*, users.* FROM employees LEFT JOIN users ON employees.user_id = users.user_id WHERE employee_id = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();

if ($employee) {
    echo json_encode($employee);
} else {
    echo json_encode(['error' => 'Employee not found']);
}

$stmt->close();
=======
<?php
include('../../backend/database.php');
header('Content-Type: application/json');
$id = $_POST['id'];

$stmt = $conn->prepare("SELECT employees.*, users.* FROM employees LEFT JOIN users ON employees.user_id = users.user_id WHERE employee_id = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();

if ($employee) {
    echo json_encode($employee);
} else {
    echo json_encode(['error' => 'Employee not found']);
}

$stmt->close();
>>>>>>> c282d3b091bf6f3005d7ecc2311a5d95b4063715
?>