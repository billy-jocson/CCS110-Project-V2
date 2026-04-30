<<<<<<< HEAD
<?php
include('../../backend/database.php');
header('Content-Type: application/json');
$depositValue = $_POST['deposit'];
$companyMoney = $_POST['companyMoney'];

$newCompanyMoney = $depositValue + $companyMoney;
$current = "PHP";
$description = "Added $depositValue to the company money.";

$stmt = $conn->prepare("INSERT INTO company_transactions(amount, currency, description) VALUES (?, ?, ?)");
$stmt->bind_param("dss", $newCompanyMoney, $current, $description); // Note: fixed $current variable name

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode([
            "status" => "success",
            "message" => "Deposit recorded successfully"
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "No rows were inserted."
        ]);
    }
}

$stmt->close();
=======
<?php
include('../../backend/database.php');
header('Content-Type: application/json');
$depositValue = $_POST['deposit'];
$companyMoney = $_POST['companyMoney'];

$newCompanyMoney = $depositValue + $companyMoney;
$current = "PHP";
$description = "Added $depositValue to the company money.";

$stmt = $conn->prepare("INSERT INTO company_transactions(amount, currency, description) VALUES (?, ?, ?)");
$stmt->bind_param("dss", $newCompanyMoney, $current, $description); // Note: fixed $current variable name

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode([
            "status" => "success",
            "message" => "Deposit recorded successfully"
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "No rows were inserted."
        ]);
    }
}

$stmt->close();
>>>>>>> c282d3b091bf6f3005d7ecc2311a5d95b4063715
?>