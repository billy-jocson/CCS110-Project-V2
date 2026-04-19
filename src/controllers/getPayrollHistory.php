<?php
include('../../backend/database.php');
$sql = "SELECT sh.*, e.first_name, e.last_name 
            FROM salary_history sh
            JOIN employees e ON sh.employee_id = e.employee_id 
            ORDER BY sh.date DESC";

$query = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($query)) {
    echo '
            <tr>
                <td>' . $row["transaction_id"] . '</td>
                <td>' . $row["employee_id"] . '</td>
                <td>' . $row["first_name"] . ' ' . $row["last_name"] . '</td>
                <td>' . number_format($row["salary_amount"], 2) . '</td>
                <td>' . $row["date"] . '</td>
            </tr>
        ';
}
?>