<?php
include('../backend/database.php');

$employeeId = $_SESSION['employeeId'];

// Determine which query to run based on user role
if ($isAdmin == 0) {
    $sql = "SELECT sh.transaction_id, sh.employee_id, sh.date, sh.salary_amount,
                   CONCAT(e.first_name, ' ', e.last_name) as full_name
            FROM salary_history sh
            JOIN employees e ON sh.employee_id = e.employee_id
            WHERE sh.employee_id = ?
            ORDER BY sh.date DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $employeeId);
    $stmt->execute();
    $query = $stmt->get_result();
    $isEmployeeView = true;
} else {
    // Admin: Show all employees' payroll history
    $sql = "SELECT sh.transaction_id, sh.employee_id, sh.date, sh.salary_amount,
                   CONCAT(e.first_name, ' ', e.last_name) as full_name
            FROM salary_history sh
            LEFT JOIN employees e ON sh.employee_id = e.employee_id
            ORDER BY sh.date DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $query = $stmt->get_result();
    $isEmployeeView = false;
}

if ($query->num_rows == 0) {
    echo "<img src='../assets/images/noHistoryFound.svg' alt='No History Found' class='w-52 relative -left-5 mx-auto'>";
    echo "<h1 class='text-zinc-600 font-medium text-center mt-5'>No history of payroll found.</h1>";
} else {
    echo '
    <div>
        <h1 class="font-bold text-3xl text-zinc-900">Payroll History</h1>
        <p class="text-zinc-500 text-sm mt-1">' . ($isEmployeeView ? 'Your Transaction History' : 'All Employees Transaction History') . '</p>
        <div class="overflow-x-auto bg-white shadow-md rounded-xl mt-10">
            <table class="min-w-full text-sm text-left text-gray-600">
                
                <thead class="bg-gradient-to-r from-sky-500 to-blue-600 text-white">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Transaction ID</th>';

    // Show employee name column only for admins
    if (!$isEmployeeView) {
        echo '<th class="px-6 py-3 font-semibold">Employee</th>';
    }

    echo '
                        <th class="px-6 py-3 font-semibold">Date</th>
                        <th class="px-6 py-3 font-semibold">Net Salary</th>
                    </tr>
                </thead>

                <tbody class="divide-y">';

    while ($row = $query->fetch_assoc()) {
        echo '
        <tr class="hover:bg-blue-50 transition-all border-0">
            <td class="px-6 py-4">' . $row["transaction_id"] . '</td>';

        // Show employee name only for admins
        if (!$isEmployeeView) {
            echo '<td class="px-6 py-4 font-medium text-gray-800">' . htmlspecialchars($row["full_name"]) . '</td>';
        }

        echo '
            <td class="px-6 py-4 text-gray-500">' . date("M d, Y", strtotime($row["date"])) . '</td>
            <td class="px-6 py-4 text-blue-600 font-semibold">
                ₱' . number_format($row["salary_amount"], 2) . '
            </td>
        </tr>';
    }

    echo '
                </tbody>
            </table>
        </div>
    </div>';
}

?>