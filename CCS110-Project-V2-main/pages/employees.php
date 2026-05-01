<?php
session_start();

if (!isset($_SESSION['fullName'])) {
    header('Location: ../login.php');
    exit;
}

if ($_SESSION['isAdmin'] != 1) {
    header('Location: dashboard.php');
    exit;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Employees | PayFlow</title>
    <script src="../assets/css/tailwindcss.js"></script>
    <style>
        * {
            font-family: 'DM Sans', sans-serif;
            scrollbar-width: thin;
        }
    </style>
</head>

<body class="bg-zinc-100">
    <div class="flex items-start">
        <?php include('../src/components/sideBar.php'); ?>

        <!-- Main Content -->
        <div class="pt-10 px-10 bg-zinc-100 w-full md:flex-1 min-h-screen md:static md:overflow-y-auto">
            <!-- Header -->
            <div class="flex items-start justify-between gap-4 flex-wrap">
                <div>
                    <h1 class="font-bold text-3xl text-zinc-900">Employees</h1>
                    <p class="text-zinc-500 text-sm mt-1">Manage your employees here.</p>
                </div>
                <div class="flex items-center bg-white px-4 py-2 rounded-full shadow-sm w-full max-w-sm gap-2">
                    <i class="fa-solid fa-magnifying-glass text-zinc-400 text-sm"></i>
                    <input id="searchInput" oninput="searchEmployee(this)" type="text"
                        placeholder="Search by employee id, name, or department"
                        class="w-full outline-none text-sm text-zinc-700 placeholder-zinc-400">
                </div>
            </div>

            <!-- Employee List Card -->
            <div class="bg-white rounded-2xl mt-6 p-6 shadow-sm">
                <div class="flex items-center justify-between flex-wrap gap-3 mb-5">
                    <div>
                        <h2 class="text-lg font-semibold text-zinc-800">Employee List</h2>
                        <p class="text-xs text-zinc-400">List of employees</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <select id="deptFilter" onchange="filterByDepartment(this)"
                            class="text-sm border border-zinc-200 rounded-lg px-3 py-2 outline-none text-zinc-700 bg-white cursor-pointer">
                            <option value="">All Departments</option>
                        </select>
                        <button onclick="openAddModal()"
                            class="bg-sky-600 hover:bg-sky-700 transition-colors text-white text-sm px-4 py-2 rounded-lg cursor-pointer">
                            Add Employee
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left text-zinc-500 border-b border-zinc-100">
                                <th class="pb-3 pr-6 font-medium">Employee Name</th>
                                <th class="pb-3 pr-6 font-medium">Emp. ID</th>
                                <th class="pb-3 pr-6 font-medium">Position</th>
                                <th class="pb-3 pr-6 font-medium">Department</th>
                                <th class="pb-3 font-medium">Action</th>
                            </tr>
                        </thead>
                        <tbody id="employeeTableBody"></tbody>
                    </table>
                    <div id="noResults" class="hidden text-center py-10 text-zinc-400 text-sm">No employees found.</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════
     EDIT EMPLOYEE MODAL
     Left: fields | Right: profile picture
══════════════════════════════════════════ -->
    <div id="editModalBg"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center invisible opacity-0 transition-all duration-300">
        <div id="editModal"
            class="bg-white rounded-2xl p-7 w-full max-w-2xl shadow-xl scale-95 opacity-0 transition-all duration-300">

            <h2 class="text-2xl font-bold text-zinc-900 mb-1">Edit Employee</h2>
            <p class="text-xs text-zinc-400 mb-5">Update the employee's information below.</p>

            <form id="editForm" onsubmit="submitEdit(event)" enctype="multipart/form-data">
                <input type="hidden" id="editEmployeeId">
                <input type="hidden" id="editUserId">

                <div class="flex gap-6">
                    <!-- Fields -->
                    <div class="flex-1 flex flex-col gap-3">
                        <div class="flex gap-3">
                            <div class="flex-1">
                                <label class="text-xs text-zinc-500 mb-1 block">First Name</label>
                                <div
                                    class="flex items-center border border-zinc-200 rounded-lg px-3 py-2 gap-2 focus-within:border-sky-400">
                                    <span class="text-zinc-400 text-xs">A.</span>
                                    <input id="editFirstName" type="text" class="w-full text-sm outline-none"
                                        placeholder="Juan" required>
                                </div>
                            </div>
                            <div class="flex-1">
                                <label class="text-xs text-zinc-500 mb-1 block">Last Name</label>
                                <div
                                    class="flex items-center border border-zinc-200 rounded-lg px-3 py-2 gap-2 focus-within:border-sky-400">
                                    <span class="text-zinc-400 text-xs">A.</span>
                                    <input id="editLastName" type="text" class="w-full text-sm outline-none"
                                        placeholder="Dela Cruz" required>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="text-xs text-zinc-500 mb-1 block">Contact Number</label>
                            <div
                                class="flex items-center border border-zinc-200 rounded-lg px-3 py-2 gap-2 focus-within:border-sky-400">
                                <i class="fa-solid fa-phone text-zinc-300 text-xs"></i>
                                <input id="editContact" type="text" class="w-full text-sm outline-none"
                                    placeholder="09XXXXXXXXX" required>
                            </div>
                        </div>
                        <div>
                            <label class="text-xs text-zinc-500 mb-1 block">Username</label>
                            <div
                                class="flex items-center border border-zinc-200 rounded-lg px-3 py-2 gap-2 focus-within:border-sky-400">
                                <span class="text-zinc-300 text-xs">@</span>
                                <input id="editUsername" type="text" class="w-full text-sm outline-none"
                                    placeholder="username123" required>
                            </div>
                        </div>
                        <div>
                            <label class="text-xs text-zinc-500 mb-1 block">Password</label>
                            <div
                                class="flex items-center border border-zinc-200 rounded-lg px-3 py-2 gap-2 focus-within:border-sky-400">
                                <i class="fa-solid fa-lock text-zinc-300 text-xs"></i>
                                <input id="editPassword" type="password" class="w-full text-sm outline-none"
                                    placeholder="Leave blank to keep current">
                            </div>
                        </div>
                        <div>
                            <label class="text-xs text-zinc-500 mb-1 block">Department</label>
                            <select id="editDept" onchange="loadEditPositions(this.value)"
                                class="w-full border border-zinc-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-sky-400 bg-white">
                            </select>
                        </div>
                        <div>
                            <label class="text-xs text-zinc-500 mb-1 block">Position</label>
                            <select id="editPosition"
                                class="w-full border border-zinc-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-sky-400 bg-white">
                            </select>
                        </div>
                    </div>

                    <!-- Profile picture -->
                    <div class="flex flex-col items-center gap-3 w-36 pt-2">
                        <img id="editProfilePreview" src="../assets/images/DefaultPFP.png" alt="Profile"
                            class="w-28 h-28 rounded-full object-cover shadow-md border border-zinc-200">
                        <label class="text-xs text-sky-600 cursor-pointer hover:underline text-center">
                            Change Profile Picture
                            <input id="editProfilePicture" name="profilePicture" type="file" accept="image/*"
                                class="hidden" onchange="previewEditPhoto(this)">
                        </label>
                    </div>
                </div>

                <div class="flex justify-between items-center mt-6">
                    <button type="button" onclick="closeEditModal()"
                        class="text-sm border border-zinc-300 text-zinc-600 rounded-lg px-5 py-2 hover:bg-zinc-100 transition-colors cursor-pointer">
                        Cancel
                    </button>
                    <button type="submit"
                        class="text-sm bg-sky-600 text-white rounded-lg px-5 py-2 hover:bg-sky-700 transition-colors cursor-pointer">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ══════════════════════════════════════════
     ADD EMPLOYEE MODAL (2-step)
     Step 1: Dept, Name, Contact, Position
     Step 2: Photo, Username, Password
══════════════════════════════════════════ -->
    <div id="addModalBg"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center invisible opacity-0 transition-all duration-300">
        <div id="addModal"
            class="bg-white rounded-2xl p-7 w-full max-w-md shadow-xl scale-95 opacity-0 transition-all duration-300">

            <h2 class="text-2xl font-bold text-zinc-900 mb-5">Add Employee</h2>

            <!-- STEP 1 -->
            <div id="addStep1">
                <div class="flex flex-col gap-4">
                    <div>
                        <label class="text-xs text-zinc-500 mb-1 block">Department</label>
                        <select id="addDept" onchange="loadAddPositions(this.value)"
                            class="w-full border border-zinc-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-sky-400 bg-white">
                            <option value="">Select Department</option>
                        </select>
                    </div>
                    <div class="flex gap-3">
                        <div class="flex-1">
                            <label class="text-xs text-zinc-500 mb-1 block">First Name</label>
                            <input id="addFirstName" type="text"
                                class="w-full border border-zinc-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-sky-400"
                                placeholder="Billy John">
                        </div>
                        <div class="flex-1">
                            <label class="text-xs text-zinc-500 mb-1 block">Last Name</label>
                            <input id="addLastName" type="text"
                                class="w-full border border-zinc-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-sky-400"
                                placeholder="Jocson">
                        </div>
                    </div>
                    <div>
                        <label class="text-xs text-zinc-500 mb-1 block">Contact Number</label>
                        <input id="addContact" type="text"
                            class="w-full border border-zinc-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-sky-400"
                            placeholder="09XXXXXXXXX">
                    </div>
                    <div>
                        <label class="text-xs text-zinc-500 mb-1 block">Position</label>
                        <select id="addPosition"
                            class="w-full border border-zinc-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-sky-400 bg-white">
                            <option value="">Select Position</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button onclick="closeAddModal()"
                        class="flex-1 border border-zinc-300 text-zinc-600 text-sm font-medium py-2.5 rounded-lg hover:bg-zinc-100 transition-colors cursor-pointer">
                        Cancel
                    </button>
                    <button onclick="goToStep2()"
                        class="flex-1 bg-zinc-900 hover:bg-zinc-700 text-white text-sm font-medium py-2.5 rounded-lg transition-colors cursor-pointer">
                        Next
                    </button>
                </div>
            </div>

            <!-- STEP 2 -->
            <div id="addStep2" class="hidden">
                <div class="flex flex-col gap-4">
                    <div>
                        <label class="text-xs text-zinc-500 mb-1 block">Portrait Picture</label>
                        <input id="addProfilePicture" type="file" accept="image/*" class="w-full text-sm text-zinc-500 border border-zinc-200 rounded-lg px-3 py-2
                               file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0
                               file:bg-zinc-100 file:text-zinc-600 hover:file:bg-zinc-200 cursor-pointer">
                    </div>
                    <div>
                        <label class="text-xs text-zinc-500 mb-1 block">Username</label>
                        <input id="addUsername" type="text"
                            class="w-full border border-zinc-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-sky-400"
                            placeholder="Enter username">
                    </div>
                    <div>
                        <label class="text-xs text-zinc-500 mb-1 block">Password</label>
                        <input id="addPassword" type="password"
                            class="w-full border border-zinc-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-sky-400"
                            placeholder="Enter password">
                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button onclick="goToStep1()"
                        class="flex-1 border border-zinc-300 text-zinc-600 text-sm font-medium py-2.5 rounded-lg hover:bg-zinc-100 transition-colors cursor-pointer">
                        Back
                    </button>
                    <button onclick="submitAdd()"
                        class="flex-1 bg-sky-600 hover:bg-sky-700 text-white text-sm font-medium py-2.5 rounded-lg transition-colors cursor-pointer">
                        Add Employee
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════
     DELETE CONFIRM MODAL
══════════════════════════════════════════ -->
    <div id="deleteModalBg"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center invisible opacity-0 transition-all duration-300">
        <div id="deleteModal"
            class="bg-white rounded-2xl p-7 w-full max-w-sm shadow-xl scale-95 opacity-0 transition-all duration-300">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-4">
                <i class="fa-solid fa-trash text-red-500 text-lg"></i>
            </div>
            <h2 class="text-xl font-bold text-zinc-900 mb-1">Delete Employee</h2>
            <p class="text-sm text-zinc-500 mb-6">Are you sure you want to remove
                <span id="deleteEmployeeName" class="font-semibold text-zinc-700"></span>?
                This action cannot be undone.
            </p>
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()"
                    class="flex-1 border border-zinc-300 text-zinc-600 text-sm font-medium py-2.5 rounded-lg hover:bg-zinc-100 transition-colors cursor-pointer">
                    Cancel
                </button>
                <button id="confirmDeleteBtn"
                    class="flex-1 bg-red-500 hover:bg-red-600 text-white text-sm font-medium py-2.5 rounded-lg transition-colors cursor-pointer">
                    Delete
                </button>
            </div>
        </div>
    </div>

    <script>
        let allEmployees = [];
        let currentDept = '';
        let deleteTargetId = null;

        // ── Load departments ────────────────────────────────────────
        async function loadDepartments() {
            const res = await fetch('../src/controllers/getDepartments.php');
            const depts = await res.json();
            const filter = document.getElementById('deptFilter');
            const addDept = document.getElementById('addDept');
            const editDept = document.getElementById('editDept');
            depts.forEach(d => {
                filter.innerHTML += `<option value="${d.dept_id}">${d.dept_name}</option>`;
                addDept.innerHTML += `<option value="${d.dept_id}">${d.dept_name}</option>`;
                editDept.innerHTML += `<option value="${d.dept_id}">${d.dept_name}</option>`;
            });
        }

        // ── Load employees ──────────────────────────────────────────
        async function loadEmployees() {
            const res = await fetch('../src/controllers/getEmployeesList.php');
            allEmployees = await res.json();
            renderTable(allEmployees);
        }

        // ── Render table ────────────────────────────────────────────
        function renderTable(employees) {
            const tbody = document.getElementById('employeeTableBody');
            const noResults = document.getElementById('noResults');
            if (employees.length === 0) {
                tbody.innerHTML = '';
                noResults.classList.remove('hidden');
                return;
            }
            noResults.classList.add('hidden');
            tbody.innerHTML = employees.map(emp => `
            <tr class="border-b border-zinc-50 hover:bg-zinc-50 transition-colors">
                <td class="py-3 pr-6">
                    <div class="flex items-center gap-3">
                        <img src="${emp.profile_link}" alt="${emp.first_name}"
                            class="aspect-square w-9 rounded-md object-cover shadow-sm">
                        <span class="text-zinc-800 font-medium">${emp.first_name} ${emp.last_name}</span>
                    </div>
                </td>
                <td class="py-3 pr-6 text-zinc-500">${emp.employee_id}</td>
                <td class="py-3 pr-6 text-zinc-700">${emp.position_name ?? '—'}</td>
                <td class="py-3 pr-6 text-zinc-700">${emp.dept_code ?? '—'}</td>
                <td class="py-3">
                    <div class="flex gap-2">
                        <button onclick="openEditModal(${emp.employee_id})"
                            class="bg-orange-400 hover:bg-orange-500 text-white text-xs px-3 py-1 rounded-md transition-colors cursor-pointer">
                            Edit
                        </button>
                        <button onclick="openDeleteModal(${emp.employee_id}, '${emp.first_name} ${emp.last_name}')"
                            class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded-md transition-colors cursor-pointer">
                            Delete
                        </button>
                    </div>
                </td>
            </tr>
        `).join('');
        }

        // ── Search ──────────────────────────────────────────────────
        let searchTimeout;
        function searchEmployee(input) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const q = input.value.toLowerCase();
                const filtered = allEmployees.filter(emp =>
                    (emp.first_name.toLowerCase().includes(q) ||
                        emp.last_name.toLowerCase().includes(q) ||
                        String(emp.employee_id).includes(q) ||
                        (emp.dept_name ?? '').toLowerCase().includes(q))
                    && (currentDept === '' || emp.dept_id == currentDept)
                );
                renderTable(filtered);
            }, 300);
        }

        // ── Dept filter ─────────────────────────────────────────────
        function filterByDepartment(select) {
            currentDept = select.value;
            const q = document.getElementById('searchInput').value.toLowerCase();
            const filtered = allEmployees.filter(emp =>
                (currentDept === '' || emp.dept_id == currentDept) &&
                (emp.first_name.toLowerCase().includes(q) ||
                    emp.last_name.toLowerCase().includes(q) ||
                    String(emp.employee_id).includes(q) ||
                    (emp.dept_name ?? '').toLowerCase().includes(q))
            );
            renderTable(filtered);
        }

        // ── Load positions ──────────────────────────────────────────
        async function loadPositions(deptId, selectId, selectedId = null) {
            const select = document.getElementById(selectId);
            select.innerHTML = '<option value="">Loading...</option>';
            const res = await fetch('../src/controllers/getPositions.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ dept_id: deptId })
            });
            const positions = await res.json();
            select.innerHTML = '<option value="">Select Position</option>' + positions.map(p =>
                `<option value="${p.position_id}" ${selectedId == p.position_id ? 'selected' : ''}>${p.position_name}</option>`
            ).join('');
        }

        function loadAddPositions(deptId) { loadPositions(deptId, 'addPosition'); }
        function loadEditPositions(deptId) { loadPositions(deptId, 'editPosition'); }

        // ── ADD MODAL ───────────────────────────────────────────────
        function openAddModal() {
            ['addFirstName', 'addLastName', 'addContact', 'addUsername', 'addPassword'].forEach(id => {
                document.getElementById(id).value = '';
            });
            document.getElementById('addDept').value = '';
            document.getElementById('addPosition').innerHTML = '<option value="">Select Position</option>';
            document.getElementById('addProfilePicture').value = '';
            goToStep1();
            showModal('addModalBg', 'addModal');
        }
        function closeAddModal() { hideModal('addModalBg', 'addModal'); }

        function goToStep1() {
            document.getElementById('addStep1').classList.remove('hidden');
            document.getElementById('addStep2').classList.add('hidden');
        }
        function goToStep2() {
            const dept = document.getElementById('addDept').value;
            const firstName = document.getElementById('addFirstName').value.trim();
            const lastName = document.getElementById('addLastName').value.trim();
            const contact = document.getElementById('addContact').value.trim();
            const position = document.getElementById('addPosition').value;
            if (!dept || !firstName || !lastName || !contact || !position) {
                alert('Please fill in all fields before proceeding.');
                return;
            }
            document.getElementById('addStep1').classList.add('hidden');
            document.getElementById('addStep2').classList.remove('hidden');
        }

        async function submitAdd() {
            const username = document.getElementById('addUsername').value.trim();
            const password = document.getElementById('addPassword').value.trim();
            if (!username || !password) {
                alert('Please enter a username and password.');
                return;
            }
            const formData = new FormData();
            formData.append('createAccount', '1');
            formData.append('firstName', document.getElementById('addFirstName').value);
            formData.append('lastName', document.getElementById('addLastName').value);
            formData.append('phone', document.getElementById('addContact').value);
            formData.append('department', document.getElementById('addDept').value);
            formData.append('position', document.getElementById('addPosition').value);
            formData.append('username', username);
            formData.append('password', password);
            const pfp = document.getElementById('addProfilePicture').files[0];
            if (pfp) formData.append('profilePicture', pfp);

            await fetch('../src/controllers/createAccount.php', { method: 'POST', body: formData });
            closeAddModal();
            loadEmployees();
        }

        // ── EDIT MODAL ──────────────────────────────────────────────
        async function openEditModal(id) {
            const formData = new FormData();
            formData.append('id', id);
            const res = await fetch('../src/controllers/getEmployeeDetails.php', { method: 'POST', body: formData });
            const emp = await res.json();

            document.getElementById('editEmployeeId').value = emp.employee_id;
            document.getElementById('editUserId').value = emp.user_id;
            document.getElementById('editFirstName').value = emp.first_name;
            document.getElementById('editLastName').value = emp.last_name;
            document.getElementById('editContact').value = emp.contact_no;
            document.getElementById('editUsername').value = emp.user_name;
            document.getElementById('editPassword').value = '';
            document.getElementById('editProfilePreview').src = emp.profile_link;

            document.getElementById('editDept').value = emp.dept_id;
            await loadPositions(emp.dept_id, 'editPosition', emp.position);

            showModal('editModalBg', 'editModal');
        }
        function closeEditModal() { hideModal('editModalBg', 'editModal'); }

        function previewEditPhoto(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => document.getElementById('editProfilePreview').src = e.target.result;
                reader.readAsDataURL(input.files[0]);
            }
        }

        async function submitEdit(e) {
            e.preventDefault();
            const formData = new FormData();
            formData.append('employee_id', document.getElementById('editEmployeeId').value);
            formData.append('user_id', document.getElementById('editUserId').value);
            formData.append('firstName', document.getElementById('editFirstName').value);
            formData.append('lastName', document.getElementById('editLastName').value);
            formData.append('phone', document.getElementById('editContact').value);
            formData.append('username', document.getElementById('editUsername').value);
            formData.append('password', document.getElementById('editPassword').value);
            formData.append('department', document.getElementById('editDept').value);
            formData.append('position', document.getElementById('editPosition').value);
            const pfp = document.getElementById('editProfilePicture').files[0];
            if (pfp) formData.append('profilePicture', pfp);

            await fetch('../src/controllers/updateEmployee.php', { method: 'POST', body: formData });
            closeEditModal();
            loadEmployees();
        }

        // ── DELETE MODAL ────────────────────────────────────────────
        function openDeleteModal(id, name) {
            deleteTargetId = id;
            document.getElementById('deleteEmployeeName').textContent = name;
            document.getElementById('confirmDeleteBtn').onclick = confirmDelete;
            showModal('deleteModalBg', 'deleteModal');
        }
        function closeDeleteModal() { hideModal('deleteModalBg', 'deleteModal'); }

        async function confirmDelete() {
            const formData = new FormData();
            formData.append('employee_id', deleteTargetId);
            await fetch('../src/controllers/deleteEmployee.php', { method: 'POST', body: formData });
            closeDeleteModal();
            loadEmployees();
        }

        // ── Modal helpers ───────────────────────────────────────────
        function showModal(bgId, modalId) {
            const bg = document.getElementById(bgId);
            const modal = document.getElementById(modalId);
            bg.classList.remove('invisible', 'opacity-0');
            bg.classList.add('opacity-100');
            setTimeout(() => {
                modal.classList.remove('opacity-0', 'scale-95');
                modal.classList.add('opacity-100', 'scale-100');
            }, 10);
        }
        function hideModal(bgId, modalId) {
            const bg = document.getElementById(bgId);
            const modal = document.getElementById(modalId);
            modal.classList.add('opacity-0', 'scale-95');
            modal.classList.remove('opacity-100', 'scale-100');
            setTimeout(() => {
                bg.classList.add('invisible', 'opacity-0');
                bg.classList.remove('opacity-100');
            }, 300);
        }

        // ── Init ────────────────────────────────────────────────────
        loadDepartments();
        loadEmployees();
    </script>
</body>

</html>