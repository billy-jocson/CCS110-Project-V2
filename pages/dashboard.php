<?php
session_start();

if (!isset($_SESSION['fullName'])) {
    header('Location: ../login.php');
}

$fullName = $_SESSION["fullName"];
$isAdmin = $_SESSION["isAdmin"];
$position = $_SESSION['position'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('../assets/fonts/fonts.php'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <title><?php echo $isAdmin == 1 ? "Admin Dashboard" : "Employee Dashboard"; ?></title>
    <script src="../assets/css/tailwindcss.js"></script>
    <style>
        * {
            font-family: 'DM Sans', sans-serif;
            scrollbar-width: thin;
        }
    </style>
</head>

<body>
    <div class="flex items-start">
        <?php include('../src/components/sideBar.php'); ?>

        <!-- Main Dashboard -->
        <div class="pt-10 px-10 bg-zinc-100 w-full md:flex-1 min-h-screen md:static md:overflow-y-auto">
            <h1 class="font-bold text-3xl text-zinc-800">
                <?php
                date_default_timezone_set('Asia/Manila');
                $hour = date('H');

                if ($hour < 12) {
                    $greeting = "Good Morning";
                } elseif ($hour < 18) {
                    $greeting = "Good Afternoon";
                } else {
                    $greeting = "Good Evening";
                }
                echo $greeting;
                ?>, <?php echo $fullName ?>
            </h1>
            <h1 class="mt-2 text-zinc-800">Here's what we have for you today.</h1>

            <!-- User Profile Image -->
            <div class="flex flex-col gap-5">
                <div class="flex flex-col lg:flex-row gap-5 mt-5 items-stretch">
                    <div class="flex-shrink-0">
                        <div class="bg-white relative w-full h-64 lg:w-56 lg:h-full rounded-2xl overflow-hidden">
                            <img src="<?php echo $_SESSION['profileLink'] ?>"
                                alt="<?php echo "$fullName Profile Picture" ?>" class="w-full h-full object-cover">
                            <div
                                class="absolute bottom-3 left-3 right-3 h-fit backdrop-blur-[3px] bg-white/50 px-4 py-3 rounded-xl">
                                <h1 class="text-zinc-950 font-semibold leading-tight">
                                    <?php echo $fullName ?>
                                </h1>
                                <h1 class="text-zinc-950 text-sm opacity-90">
                                    Employee ID: <?php echo $_SESSION['employeeId'] ?>
                                </h1>
                            </div>
                        </div>
                    </div>


                    <div class="bg-white w-full p-5 rounded-lg">
                        <small class="text-zinc-800">Today is</small>
                        <h1 class="text-zinc-800 text-3xl font-bold block mb-3"><?php echo date('F d, Y') ?></h1>
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-3 relative">
                            <?php include('../src/controllers/isPayrollAvailable.php'); ?>
                        </div>
                    </div>
                </div>

                <!-- Bottom Section -->
                <div class="flex flex-col lg:flex-row gap-5">

                    <!-- Recent Payroll History -->
                    <div class="bg-white rounded-2xl p-5 shadow-sm flex-1 flex flex-col">
                        <h2 class="font-semibold text-zinc-800 mb-4">Recent Payroll History</h2>
                        <?php
                        include '../backend/database.php';
                        $empId = $_SESSION['employeeId'];
                        $history = $conn->query("
                            SELECT sh.date, sh.salary_amount, sh.bonus, sh.deduction
                            FROM salary_history sh
                            WHERE sh.employee_id = $empId
                            ORDER BY sh.date DESC
                            LIMIT 5
                        ");
                        $rows = $history->fetch_all(MYSQLI_ASSOC);
                        ?>
                        <?php if (count($rows) > 0): ?>
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="text-left text-zinc-400 border-b border-zinc-100">
                                        <th class="pb-2 font-medium">Date</th>
                                        <th class="pb-2 font-medium">Amount</th>
                                        <th class="pb-2 font-medium">Bonus</th>
                                        <th class="pb-2 font-medium">Deduction</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rows as $row): ?>
                                        <tr class="border-b border-zinc-50">
                                            <td class="py-2 text-zinc-600">
                                                <?php echo date('M d, Y', strtotime($row['date'])); ?>
                                            </td>
                                            <td class="py-2 text-zinc-800 font-medium">
                                                ₱<?php echo number_format($row['salary_amount'], 2); ?></td>
                                            <td class="py-2 text-green-600 font-medium">
                                                +₱<?php echo number_format($row['bonus'] ?? 0, 2); ?></td>
                                            <td class="py-2 text-red-500 font-medium">
                                                -₱<?php echo number_format($row['deduction'] ?? 0, 2); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div class="flex flex-col items-center justify-center py-8 text-zinc-400">
                                <i class="fa-solid fa-clock-rotate-left text-3xl mb-2"></i>
                                <p class="text-sm">No payroll history yet.</p>
                            </div>
                        <?php endif; ?>
                        <a href="payrollHistory.php" class="text-xs text-sky-600 hover:underline mt-auto block">View all
                            →</a>
                    </div>

                    <!-- Salary Breakdown -->
                    <div class="bg-white rounded-2xl p-5 shadow-sm w-full lg:w-72">
                        <h2 class="font-semibold text-zinc-800 mb-4">Salary Breakdown</h2>
                        <?php
                        $salaryStmt = $conn->prepare("
                            SELECT base_pay, bonus, deduction,
                                   (base_pay + bonus - deduction) AS net_salary
                            FROM salary_structure
                            WHERE employee_id = ?
                        ");
                        $salaryStmt->bind_param('i', $empId);
                        $salaryStmt->execute();
                        $sal = $salaryStmt->get_result()->fetch_assoc();
                        ?>
                        <div class="flex flex-col gap-3">
                            <div class="flex justify-between items-center py-2 border-b border-zinc-100">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-sky-500 inline-block"></span>
                                    <span class="text-sm text-zinc-500">Base Pay</span>
                                </div>
                                <span
                                    class="text-sm font-semibold text-zinc-800">₱<?php echo number_format($sal['base_pay'] ?? 0, 2); ?></span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-zinc-100">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-green-400 inline-block"></span>
                                    <span class="text-sm text-zinc-500">Bonus</span>
                                </div>
                                <span
                                    class="text-sm font-semibold text-green-600">+₱<?php echo number_format($sal['bonus'] ?? 0, 2); ?></span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-zinc-100">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-red-400 inline-block"></span>
                                    <span class="text-sm text-zinc-500">Deduction</span>
                                </div>
                                <span
                                    class="text-sm font-semibold text-red-500">-₱<?php echo number_format($sal['deduction'] ?? 0, 2); ?></span>
                            </div>
                            <div class="flex justify-between items-center pt-2">
                                <span class="text-sm font-bold text-zinc-700">Net Salary</span>
                                <span
                                    class="text-base font-bold text-sky-600">₱<?php echo number_format($sal['net_salary'] ?? 0, 2); ?></span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</body>

</html>