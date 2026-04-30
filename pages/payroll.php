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
    <title>Payroll</title>
    <?php include('../assets/fonts/fonts.php'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <script src="../assets/css/tailwindcss.js"></script>
</head>

<body class="bg-zinc-100">
    <?php if ($isAdmin): ?>
        <div class="flex h-screen overflow-hidden">
            <?php include('../src/components/sideBar.php'); ?>

            <!-- Table Card -->
            <div class="bg-zinc-100 w-full shadow-sm overflow-scroll p-8">
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-900">Payroll</h1>
                    <p class="text-sm text-gray-500 mt-1">Give your employees' payrolls here.</p>
                </div>
                <table class="w-full bg-white rounded-2xl">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="text-left text-sm font-medium text-gray-500 px-6 py-4">Employee Name</th>
                            <th class="text-left text-sm font-medium text-gray-500 px-6 py-4">Base Pay</th>
                            <th class="text-left text-sm font-medium text-gray-500 px-6 py-4">Bonus</th>
                            <th class="text-left text-sm font-medium text-gray-500 px-6 py-4">Deductions</th>
                            <th class="text-left text-sm font-medium text-gray-500 px-6 py-4">Status/Action</th>
                        </tr>
                    </thead>
                    <tbody id="payroll-table-body">
                        <!-- Payroll data will be dynamically inserted here -->
                    </tbody>
                </table>
            </div>

            <?php include('../src/components/employeeModal.php'); ?>
        </div>
    <?php endif; ?>
    <?php if (!$isAdmin) {
        include("../src/components/acceptPaymentModal.php");
    }
    ?>
</body>

<script>
    const payrollTableBody = document.getElementById('payroll-table-body');
    fetchPayrollData();

    function fetchPayrollData() {
        fetch('../src/controllers/getPayroll.php')
            .then(response => response.json())
            .then(data => {
                payrollTableBody.innerHTML = "";
                data.forEach((employee, index) => {
                    const isLast = index === data.length - 1;
                    const row = document.createElement('tr');
                    row.className = `${!isLast ? 'border-b border-gray-100' : ''} hover:bg-gray-50 transition-colors duration-150`;

                    let statusHtml = '';
                    if (employee.is_available == -1) {
                        statusHtml = `<span class="flex items-center gap-1.5 text-sm font-medium text-green-500">
                                        <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span>
                                        Payment Success
                                      </span>`;
                    } else if (employee.is_available == 1) {
                        statusHtml = `<span class="flex items-center gap-1.5 text-sm font-medium text-amber-500">
                                        <span class="w-2 h-2 rounded-full bg-amber-500 inline-block"></span>
                                        Payment Pending
                                      </span>`;
                    } else {
                        statusHtml = `<button onclick="openModal(${employee.employee_id})"
                                        class="cursor-pointer bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium px-5 py-1.5 rounded-md transition-colors duration-150">
                                        View
                                      </button>`;
                    }

                    row.innerHTML = `
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="${employee.profile_link}" alt="${employee.full_name}"
                                     class="w-10 h-10 rounded-lg object-cover flex-shrink-0 bg-gray-200" />
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">${employee.full_name}</p>
                                    <p class="text-xs text-gray-400">SFN - ${employee.employee_id}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">$${employee.base_pay}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">$${employee.bonus}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">$${employee.deduction}</td>
                        <td class="px-6 py-4">${statusHtml}</td>
                    `;
                    payrollTableBody.appendChild(row);
                });
            })
            .catch(error => console.error('Error fetching payroll data:', error));
    }

    function openModal(dataId) {
        const blurBg = document.getElementById('blurBg');
        blurBg.classList.remove('invisible', 'bg-black/0');
        blurBg.classList.add('bg-black/50', 'backdrop-blur-sm');

        const employeeDetails = document.getElementById('employeeDetails');
        employeeDetails.classList.remove('opacity-0', 'scale-95');
        employeeDetails.classList.add('opacity-100', 'scale-100');

        fetch(`../src/controllers/getEmployeeSalary.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id: dataId
            })
        }).then(res => res.json())
            .then(data => {
                console.log(data[0]);
                document.getElementById('profilePicture').src = `${data[0].profile_link}`;
                document.getElementById('username').innerText = data[0].user_name;
                document.getElementById('name').innerText = data[0].full_name;
                document.getElementById('position').innerText = data[0].position_name;
                document.getElementById('basePay').innerText = `$${data[0].base_pay}`;
                document.getElementById('bonus').innerText = `$${data[0].bonus}`;
                document.getElementById('deduction').innerText = `$${data[0].deduction}`;
                document.getElementById('netSalary').innerText = `$${(parseFloat(data[0].base_pay) + parseFloat(data[0].bonus)) - parseFloat(data[0].deduction)}`;

                document.getElementById('givePayrollBtn').onclick = function () {
                    fetch('../src/controllers/givePayroll.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id: dataId
                        })
                    }).then(res => res.json())
                        .then(data => {
                            alert("Payroll Given Successfully!");
                            closeModal();
                            fetchPayrollData();
                        })
                }
            })
    }
</script>

</html>