<?php
include("../../backend/database.php");
switch ($_POST["choice"]) {
    case 1:
        $id = $_POST["id"];
        $result = mysqli_query($conn, "SELECT employee_id FROM resignation_request WHERE resign_id = $id");
        $employee_id = $result->fetch_assoc();

        mysqli_query($conn, "UPDATE resignation_request SET status = 1  WHERE resign_id = $id");
        mysqli_query($conn, "UPDATE employees SET is_resigned = 1 WHERE employee_id = $employee_id[employee_id]");
        break;

    case 2:
        $id = $_POST["id"];
        mysqli_query($conn, "UPDATE resignation_request SET status = 2  WHERE resign_id = $id");
        break;
}
?>