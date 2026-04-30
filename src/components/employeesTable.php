<?php
include('../backend/database.php');
$sql = mysqli_query($conn, "SELECT e.*, u.* FROM employees e LEFT JOIN users u ON e.user_id = u.user_id");
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
        <input oninput="searchEmployee(event, this)" type="text"
            placeholder="Search by employee id, name, or department" class="w-full px-4 py-1 outline-none">
    </div>
</div>
<div class="container mx-auto">
    <div class="py-8">
        <div>
            <h2 class="text-2xl font-semibold leading-tight my-2">Invoices</h2>
        </div>
        <div class="overflow-x-auto overflow-y-auto max-h-[300px] border border-gray-200 rounded-lg">
            <div class="inline-block min-w-full shadow-sm">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th
                                class="sticky top-0 px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Client / Invoice
                            </th>
                            <th
                                class="sticky top-0 px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Amount
                            </th>
                            <th
                                class="sticky top-0 px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Issued / Due
                            </th>
                            <th
                                class="sticky top-0 px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Status / Action
                            </th>
                        </tr>
                    </thead>
                    <tbody id="employeesTableBody">
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
                                            <p class="text-gray-900 whitespace-nowrap">
                                                <?php echo "$employee[first_name] $employee[last_name]"; ?>
                                            </p>
                                            <p class="text-gray-600 whitespace-nowrap">
                                                <?php echo $employee['employee_id'] ?>
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-nowrap">$20,000</p>
                                    <p class="text-gray-600 whitespace-nowrap">PHP</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-nowrap">Sept 28, 2019</p>
                                    <p class="text-gray-600 whitespace-nowrap">Due in 3 days</p>
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
<script>
    async function viewProfile(e, btn) {
        const blurBg = document.querySelector("#blurBg");
        const employeeDetails = document.querySelector("#employeeDetails");

        e.preventDefault();
        const formData = new FormData();
        formData.append('id', btn.dataset.id);

        const employee = await fetch('../src/controllers/getEmployeeDetails.php', { method: "POST", body: formData })
            .then(response => response.json())
            .then(data => openModal(data));
    }

    function openModal(employee) {
        const username = document.querySelector("#username");
        const name = document.querySelector("#name");
        const position = document.querySelector("#position");
        const profilePicture = document.querySelector('#profilePicture');

        profilePicture.setAttribute('src', `${employee.profile_link}`)
        username.innerHTML = `@${employee.user_name}`;
        name.innerHTML = `${employee.first_name} ${employee.last_name}`;
        position.innerHTML = `${employee.position}`;

        blurBg.classList.add('bg-black/50', 'backdrop-blur-sm');
        blurBg.classList.remove('bg-black/0', 'invisible');

        employeeDetails.classList.add('opacity-100', 'scale-100');
        employeeDetails.classList.remove('opacity-0', 'scale-95');
    }

    let searchTimeout;

    async function searchEmployee(event, input) {
        const tblBody = document.querySelector('#employeesTableBody');
        clearTimeout(searchTimeout);

        searchTimeout = setTimeout(async () => {
            const toSearch = input.value;
            const formData = new FormData();
            formData.append('toSearch', toSearch);

            try {
                const response = await fetch('../src/controllers/searchAndFilter.php', {
                    method: "POST",
                    body: formData
                });
                const data = await response.json();
                tblBody.innerHTML = '';

                data.forEach(emp => {
                    const row = `
                        <tr>
                            <td>${emp.id}</td>
                            <td>${emp.full_name}</td>
                            <td>${emp.dept}</td>
                        </tr>
                    `;
                    tblBody.innerHTML += row;
                });

            } catch (error) {
                console.error("Error fetching employees:", error);
            }
        }, 500);
    }
</script>