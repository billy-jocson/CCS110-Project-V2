<?php
include('../backend/database.php');
$sql = mysqli_query($conn, "SELECT employees.*, users.* FROM employees LEFT JOIN users ON employees.user_id = users.user_id");
?>

<div class="flex items-center justify-between gap-2 ">
    <div class="flex items-center w-full bg-white px-3 py-1 rounded-full">
        <span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
        </span>
        <input type="text" placeholder="Search by employee id, name, or department"
            class="w-full px-4 py-1 outline-none">
    </div>

    <div class="w-full">
        <button>All Employees</button>
        <select name="departmentFilter">
            <option value="1">Human Resources Department</option>
            <option value="2">IT Department</option>
            <option value="3">Finance Department</option>
            <option value="4">Marketing Department</option>
            <option value="5">Operations Department</option>
        </select>
    </div>
</div>
<div class="container">
    <div>
        <div>
            <h2 class="text-2xl font-semibold leading-tight my-2">Invoices</h2>
        </div>
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full shadow-sm rounded-lg overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Client / Invoice
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Amount
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Issued / Due
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Status / Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($employee = mysqli_fetch_array($sql)): ?>
                            <tr>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <div class="flex">
                                        <div class="flex-shrink-0 w-10 h-10">
                                            <img class="w-full h-full rounded-full object-cover"
                                                src="<?php echo $employee['profile_link']; ?>"
                                                alt="<?php echo "$employee[last_name] profile picture." ?>" />
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                <?php echo "$employee[first_name] $employee[last_name]"; ?>
                                            </p>
                                            <p class="text-gray-600 whitespace-no-wrap">
                                                <?php echo $employee['employee_id'] ?>
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">$20,000</p>
                                    <p class="text-gray-600 whitespace-no-wrap">USD</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">Sept 28, 2019</p>
                                    <p class="text-gray-600 whitespace-no-wrap">Due in 3 days</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <button onclick="viewProfile(event, this)"
                                        data-id="<?php echo $employee['employee_id'] ?>"
                                        class="bg-sky-600 px-3 py-1 rounded-lg cursor-pointer text-white hover:bg-sky-900 transition-colors">View</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include('employeeModal.php') ?>