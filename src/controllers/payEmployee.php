
<?php
include('../../backend/database.php');

header('Content-Type: application/json');
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (isset($data['user_id'])) {
    $userId = $data['user_id'];
    $updateQuery = "UPDATE users SET is_paid = 1 WHERE user_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("i", $userId);
    
    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'Failed to pay employee.']);
        exit();
    } 
    $updateCompanyMoneyQuery ="UPDATE company_transactions 
            SET amount = amount - 
            (SELECT s.base_pay AS pay_amount 
            FROM salary_structure AS s, employees AS e, users AS u 
            WHERE s.employee_id = e.employee_id 
            AND u.user_id = e.user_id 
            AND ? = e.user_id) 
            WHERE transaction_id = 1;";
    
    $stmtCompanyMoney = $conn->prepare($updateCompanyMoneyQuery);
    $stmtCompanyMoney->bind_param("i", $userId);
    if (!$stmtCompanyMoney->execute()) {
        echo json_encode(['success' => false, 'message' => 'Failed to update company money.']);
        exit();
    }
    $getSalaryTransaction = "SELECT s.employee_id, s.salary_id,(s.base_pay + s.bonus) - s.deduction AS net_salary 
                    FROM salary_structure AS s 
                    INNER JOIN employees AS e 
                    ON s.employee_id = e.employee_id
                    WHERE e.user_id = ?";
    $stmtGetSalary = $conn->prepare($getSalaryTransaction);
    $stmtGetSalary->bind_param("i", $userId);
    if (!$stmtGetSalary->execute()) {
        echo json_encode(['success' => false, 'message' => 'Failed to retrieve salary transaction.']);
        exit();
    }
    $transaction = $stmtGetSalary->get_result()->fetch_assoc();

    $insertSalaryHistoryQuery = "INSERT INTO salary_history(employee_id,salary_id,salary_amount) VALUES(?,?,?)";
    $stmtInsertSalaryHistory = $conn->prepare($insertSalaryHistoryQuery);
    $stmtInsertSalaryHistory->bind_param("iid", $transaction['employee_id'], $transaction['salary_id'], $transaction['net_salary']);
    if (!$stmtInsertSalaryHistory->execute()) {
        echo json_encode(['success' => false, 'message' => 'Failed to insert salary history.']);
        exit();
    }
} else {
    echo json_encode(['success' => false, 'message' => 'User ID not provided.']);
}
?>