<?php
include('../backend/database.php');
?>

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
