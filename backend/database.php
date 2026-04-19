<?php
$host_name = "localhost";
$username = "root";
$password = "";
$db_name = "company_db2";

try {
    $conn = mysqli_connect($host_name, $username, $password, $db_name);
} catch (mysqli_sql_exception) {
    die("Cannot connect!");
}
?>