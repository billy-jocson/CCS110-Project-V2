<?php
include('../../backend/database.php');
header('Content-Type: application/json');

$sql = mysqli_query($conn, 'SELECT amount FROM company_transactions ORDER BY id DESC LIMIT 1');
$money = mysqli_fetch_assoc($sql);

if (!$money) {
    echo json_encode(['amount' => 0]);
} else {
    echo json_encode($money);
}
?>