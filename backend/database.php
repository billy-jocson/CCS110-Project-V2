<?php
$host_name = "localhost";
$username = "root";
$password = "";
$db_name = "company"; // company lang pinangalan ko sa database so it depends sa pinangalan nyo

try {
    $conn = mysqli_connect($host_name, $username, $password, $db_name);
} catch (mysqli_sql_exception) {
    die("Cannot connect!");
}
?>