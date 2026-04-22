<?php
include('../../backend/database.php');
$employees = mysqli_query($conn, "SELECT e.user_id, e.first_name, e.last_name, s.base_pay,s.bonus,s.deduction, u.is_paid FROM salary_structure as s LEFT JOIN employees as e ON s.employee_id = e.employee_id LEFT JOIN users as u ON u.user_id = e.user_id WHERE e.is_resigned = false");
//eto pla ung query for getting paid and unpaid count kung icocomponentes mo pa sya lead
$paidCount = mysqli_query($conn, "SELECT COUNT(*) as count FROM users WHERE is_paid = 1  AND user_id IN (SELECT user_id FROM employees WHERE is_resigned = false)");
$unpaidCount = mysqli_query($conn, "SELECT COUNT(*) as count FROM users WHERE is_paid = 0 AND user_id IN (SELECT user_id FROM employees WHERE is_resigned = false)");
?>
<!--placeholders -->
<div>   
    <p>Paid Employees: <?php echo mysqli_fetch_assoc($paidCount)['count']; ?></p>
    <p>Unpaid Employees: <?php echo mysqli_fetch_assoc($unpaidCount)['count']; ?></p>
</div>

<table>
    <thead>
        <tr>
            <th>Employee</th>
            <th>Salary</th>
            <th>Deductions</th>
            <th>Bonuses</th>
            <th>Net Pay</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody> 
        <?php while ($employee = mysqli_fetch_array($employees)): ?>
            <tr>
                <td><?php echo "$employee[first_name] $employee[last_name]"; ?></td>
                <td><?php echo $employee['base_pay']; ?></td>
                <td><?php echo $employee['deduction']; ?></td>
                <td><?php echo $employee['bonus']; ?></td>
                <td><?php echo $employee['base_pay'] + $employee['bonus'] - $employee['deduction']; ?></td>
                <td>
                <?php echo $employee['is_paid'] ? 'Paid' : '<button class="btnPay" data-salary-id="' . $employee['user_id'] . '">Pay</button>';?>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<script>
    document.querySelectorAll('.btnPay').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.getAttribute('data-salary-id');
            //lead d aq pamilyar sa FormData so nag json aq 
            fetch(`../controllers/payEmployee.php`, {
                method : 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ user_id: userId })
            })
            .then(res => res.json())
            .then(data => {
                //alert muna
                if(data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            }); 
        }); 
    }); 
</script>