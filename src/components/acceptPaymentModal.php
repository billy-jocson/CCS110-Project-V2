<?php
$id = $_SESSION['employeeId'];
include("../backend/database.php");

$mysql = mysqli_query($conn, "SELECT s.base_pay, s.bonus, s.deduction, s.is_available 
    FROM employees AS e 
    INNER JOIN salary_structure AS s ON s.employee_id = e.employee_id 
    INNER JOIN users AS u ON u.user_id = e.user_id 
    WHERE e.is_resigned = 0 AND s.employee_id = $id");

$result = mysqli_fetch_assoc($mysql);
$net = ($result["base_pay"] + $result["bonus"]) - $result["deduction"];
?>

<div class="flex h-screen bg-zinc-100">
    <?php include('../src/components/sideBar.php'); ?>

    <div class="flex-1 flex items-center justify-center p-6">
        <?php if ($result): ?>
            <div class="w-full max-w-lg bg-white rounded-3xl shadow-xl border border-zinc-100 p-8">

                <!-- Header -->
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-zinc-800">Payroll Summary</h1>
                    <p class="text-sm text-zinc-500">Breakdown of your latest salary</p>
                </div>

                <!-- Net Salary Highlight -->
                <div class="bg-gradient-to-r from-sky-600 to-blue-500 text-white rounded-2xl p-6 mb-6 shadow-md">
                    <p class="text-sm opacity-80">Net Salary</p>
                    <h2 class="text-3xl font-black mt-1">₱<?= number_format($net, 2); ?></h2>
                </div>

                <!-- Breakdown -->
                <div class="space-y-4 text-sm">

                    <div class="flex justify-between items-center bg-zinc-50 p-4 rounded-xl">
                        <span class="text-zinc-600">Base Pay</span>
                        <span class="font-semibold text-zinc-800">₱<?= number_format($result["base_pay"], 2); ?></span>
                    </div>

                    <div class="flex justify-between items-center bg-emerald-50 p-4 rounded-xl">
                        <span class="text-emerald-700">Bonuses</span>
                        <span class="font-semibold text-emerald-700">+ ₱<?= number_format($result["bonus"], 2); ?></span>
                    </div>

                    <div class="flex justify-between items-center bg-red-50 p-4 rounded-xl">
                        <span class="text-red-600">Deductions</span>
                        <span class="font-semibold text-red-600">- ₱<?= number_format($result["deduction"], 2); ?></span>
                    </div>

                </div>

                <!-- Actions -->
                <div class="mt-8">

                    <?php if ($result["is_available"] == 1): ?>
                        <button onclick="acceptPayment(<?= $id ?>)"
                            class="w-full py-4 bg-sky-600 text-white rounded-xl font-bold hover:bg-sky-700 transition shadow-md">
                            Confirm Receipt
                        </button>

                    <?php elseif ($result["is_available"] == 0): ?>
                        <button disabled class="w-full py-4 bg-zinc-200 text-zinc-400 rounded-xl font-bold cursor-not-allowed">
                            Pending Approval
                        </button>

                    <?php elseif ($result["is_available"] == -1): ?>
                        <div
                            class="w-full py-4 bg-emerald-100 text-emerald-700 rounded-xl font-bold text-center border border-emerald-200">
                            Payroll Received
                        </div>
                    <?php endif; ?>

                    <p class="text-xs text-center text-zinc-400 mt-3">
                        Payroll is released twice a month or upon admin approval.
                    </p>

                </div>

            </div>
        <?php else: ?>
            <div class="text-center text-zinc-500">
                <h1 class="text-xl font-semibold">No Payroll Available</h1>
                <p class="text-sm mt-2">Please wait for the next payroll release.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    function acceptPayment(id) {
        fetch("../src/controllers/processPayment.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id: id })
        })
            .then(res => res.json())
            .then(data => {
                alert("Payment confirmed!");
                location.reload();
            });
    }
</script>