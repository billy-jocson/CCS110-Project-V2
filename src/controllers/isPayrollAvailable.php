<?php
include '../backend/database.php';

$employeeId = $_SESSION['employeeId'];

// Get employee details + salary structure + position + department
$stmt = $conn->prepare("
    SELECT 
        e.first_name, e.last_name, e.contact_no,
        p.position_name,
        d.dept_name,
        s.base_pay, s.bonus, s.deduction, s.is_available,
        (s.base_pay + s.bonus - s.deduction) AS net_salary
    FROM employees e
    LEFT JOIN positions p ON e.position = p.position_id
    LEFT JOIN departments d ON e.dept_id = d.dept_id
    LEFT JOIN salary_structure s ON e.employee_id = s.employee_id
    WHERE e.employee_id = ?
");
$stmt->bind_param('i', $employeeId);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
?>

<!-- Payroll Status Card -->
<div class="bg-gradient-to-br from-sky-500 to-sky-700 rounded-xl p-4 flex-1 min-w-[160px]">
    <p class="text-xs text-sky-200 mb-1">Payroll Status</p>
    <?php if ($data['is_available'] == 1): ?>
        <span class="inline-flex items-center gap-1 bg-white/20 text-white text-xs font-semibold px-2.5 py-1 rounded-full">
            <i class="fa-solid fa-circle-check text-xs"></i> Available
        </span>
        <p class="text-xs text-sky-100 mt-2">Your payroll is ready. Check the Payroll page.</p>
    <?php elseif ($data['is_available'] == -1): ?>
        <span class="inline-flex items-center gap-1 bg-white/20 text-white text-xs font-semibold px-2.5 py-1 rounded-full">
            <i class="fa-solid fa-circle-check text-xs"></i> Received
        </span>
        <p class="text-xs text-sky-100 mt-2">You have already received your payroll.</p>
    <?php else: ?>
        <span class="inline-flex items-center gap-1 bg-white/20 text-white text-xs font-semibold px-2.5 py-1 rounded-full">
            <i class="fa-solid fa-clock text-xs"></i> Pending
        </span>
        <p class="text-xs text-sky-100 mt-2">No payroll available yet.</p>
    <?php endif; ?>
</div>

<!-- Position Card -->
<div class="bg-gradient-to-br from-violet-500 to-purple-700 rounded-xl p-4 flex-1 min-w-[160px]">
    <p class="text-xs text-violet-200 mb-1">Position</p>
    <p class="text-sm font-semibold text-white"><?php echo $data['position_name'] ?? '—'; ?></p>
    <p class="text-xs text-violet-200 mt-1"><?php echo $data['dept_name'] ?? '—'; ?></p>
</div>

<!-- Salary Card -->
<div class="bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-xl p-4 flex-1 min-w-[160px]">
    <p class="text-xs text-emerald-100 mb-1">Base Pay</p>
    <p class="text-sm font-semibold text-white">₱<?php echo number_format($data['base_pay'] ?? 0, 2); ?></p>
    <p class="text-xs text-emerald-100 mt-1">Net: ₱<?php echo number_format($data['net_salary'] ?? 0, 2); ?></p>
</div>

<!-- Contact Card -->
<div class="bg-gradient-to-br from-orange-400 to-rose-500 rounded-xl p-4 flex-1 min-w-[160px]">
    <p class="text-xs text-orange-100 mb-1">Contact No.</p>
    <p class="text-sm font-semibold text-white"><?php echo $data['contact_no'] ?? '—'; ?></p>
    <p class="text-xs text-orange-100 mt-1"><?php echo $data['dept_name'] ?? '—'; ?> Dept.</p>
</div>