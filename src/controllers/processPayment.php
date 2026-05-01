<?php

include('../../backend/database.php');
//natagalan me dto na eecho pla toh kaya ayw gumana nilgyan q nyan sabi ni tropa q
ob_start();
include 'getCompanyMoney.php';
ob_clean();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $id = $data['id'] ?? null;

    if ($id) {
        $mysql1 = "SELECT salary_id, base_pay, bonus, deduction FROM salary_structure WHERE employee_id = ?";
        $stmt1 = $conn->prepare($mysql1);
        $stmt1->bind_param("i", $id);
        $stmt1->execute();
        $paymentData = $stmt1->get_result()->fetch_assoc();

        if ($paymentData) {
            $salary_id = $paymentData['salary_id'];
            $currency = "PHP";
            $amount = ($paymentData['base_pay'] + $paymentData['bonus']) - $paymentData["deduction"];
            $description = "Gave payroll amounting: $amount — to employee id: $id";
            $newCompanyMoney = $money['amount'] - $amount;

            $mysql2 = "UPDATE salary_structure SET is_available = -1 WHERE employee_id = ?";
            $stmt2 = $conn->prepare($mysql2);
            $stmt2->bind_param("i", $id);
            $stmt2->execute();

            $mysql3 = "INSERT INTO salary_history (employee_id, salary_id, salary_amount,base_pay,bonus,deduction) VALUES (?, ?, ?, ?, ? ,?)";
            $stmt3 = $conn->prepare($mysql3);
            $stmt3->bind_param("iidddd", $id, $salary_id, $amount,$paymentData['base_pay'],$paymentData['bonus'],$paymentData["deduction"]);
            $stmt3->execute();

            $mysql4 = "INSERT INTO company_transactions(amount, currency, description) VALUES (?, ?, ?)";
            $stmt4 = $conn->prepare($mysql4);
            $stmt4->bind_param("dss", $newCompanyMoney, $currency, $description);
            $stmt4->execute();

            echo json_encode(["success" => true, "message" => "Payroll processed"]);
        } else {
            echo json_encode(["success" => false, "message" => "Salary data not found"]);
        }
    }
}
?>