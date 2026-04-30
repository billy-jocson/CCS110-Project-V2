<?php
$employeeId = $_SESSION['employeeId'];
include("../../backend/database.php");
switch ($_POST["choice"]) {
    case 1:
        $id = $_POST["id"];
        mysqli_query($conn, "UPDATE resignation_request SET status = 1  WHERE resign_id = $id");
        mysqli_query($conn, "UPDATE employees SET is_resigned = 1 WHERE employee_id = $employeeId");
        break;

    case 2:
        $id = $_POST["id"];
        mysqli_query($conn, "UPDATE resignation_request SET status = 2  WHERE resign_id = $id");
        break;
}
?>