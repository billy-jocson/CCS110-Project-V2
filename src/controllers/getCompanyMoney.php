<?php
include('../../backend/database.php');
header('Content-Type: application/json');

$stmt = $conn->prepare('SELECT amount FROM company_transactions ORDER BY transaction_id DESC LIMIT 1');
$stmt->execute();
$result = $stmt->get_result();
$money = $result->fetch_assoc();

if (!$money) {
    $money = 0;
    echo json_encode($money);
} else {
    echo json_encode($money);
}
$stmt->close();
?>