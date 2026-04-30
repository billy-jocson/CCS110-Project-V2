<<<<<<< HEAD
<?php
header('Content-Type: application/json');
include('../../backend/database.php');
$stmt = $conn->prepare("SELECT users.*, employees.employee_id, employees.position, employees.first_name, employees.last_name
    FROM users
    LEFT JOIN employees ON users.user_id = employees.user_id
    WHERE users.user_name = ?
");

$stmt->bind_param('s', $_POST['username']);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if ($result && password_verify($_POST['password'], $result['password'])) {
    session_start();
    $_SESSION['fullName'] = "$result[first_name] $result[last_name]";
    $_SESSION['isAdmin'] = $result['is_admin'];
    $_SESSION['profileLink'] = $result['profile_link'];
    $_SESSION['position'] = $result['position'];
    $_SESSION['employeeId'] = $result['employee_id'];

    echo json_encode(["status" => "success", "msg" => "correct credentials"]);
} else {
    echo json_encode(["status" => "error", "msg" => "Incorrect credentials!"]);
}
=======
<?php
header('Content-Type: application/json');
include('../../backend/database.php');
$stmt = $conn->prepare("SELECT users.*, employees.employee_id, employees.position, employees.first_name, employees.last_name
    FROM users
    LEFT JOIN employees ON users.user_id = employees.user_id
    WHERE users.user_name = ?
");

$stmt->bind_param('s', $_POST['username']);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if ($result && password_verify($_POST['password'], $result['password'])) {
    session_start();
    $_SESSION['fullName'] = "$result[first_name] $result[last_name]";
    $_SESSION['isAdmin'] = $result['is_admin'];
    $_SESSION['profileLink'] = $result['profile_link'];
    $_SESSION['position'] = $result['position'];
    $_SESSION['employeeId'] = $result['employee_id'];

    echo json_encode(["status" => "success", "msg" => "correct credentials"]);
} else {
    echo json_encode(["status" => "error", "msg" => "Incorrect credentials!"]);
}
>>>>>>> c282d3b091bf6f3005d7ecc2311a5d95b4063715
?>