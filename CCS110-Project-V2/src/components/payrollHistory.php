<h1>Payroll History</h1>
<h3> Transaction History</h3>

<table border="1">
    <thead>
        <tr>
            <th>Transaction ID</th>
            <th>Employee ID</th>
            <th>Employee</th>
            <th>Net Salary</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include("../controllers/getPayrollHistory.php")
            ?>
    </tbody>
</table>