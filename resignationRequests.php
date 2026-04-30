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
$isAdmin  = $_SESSION["isAdmin"];
$position = $_SESSION['position'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('../assets/fonts/fonts.php'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Resignation Requests | PayFlow</title>
    <script src="../assets/css/tailwindcss.js"></script>
    <style>
        * { font-family: 'DM Sans', sans-serif; scrollbar-width: thin; }
    </style>
</head>
<body class="bg-zinc-100">
<div class="flex items-start relative">
    <?php include('../src/components/sideBar.php'); ?>

    <div class="pt-10 px-10 bg-zinc-100 w-full min-h-screen absolute left-0 md:static">

        <!-- Header -->
        <div>
            <h1 class="font-bold text-3xl text-zinc-900">Resignation Requests</h1>
            <p class="text-zinc-500 text-sm mt-1">List of all employee resignation requests.</p>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-2xl mt-6 p-6 shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="text-left text-zinc-500 border-b border-zinc-100">
                            <th class="pb-3 pr-6 font-medium">Employee</th>
                            <th class="pb-3 pr-6 font-medium">Position</th>
                            <th class="pb-3 pr-6 font-medium">Status</th>
                            <th class="pb-3 pr-6 font-medium">Download File</th>
                            <th class="pb-3 font-medium">Action</th>
                        </tr>
                    </thead>
                    <tbody id="resignationTableBody"></tbody>
                </table>
                <div id="noResults" class="hidden text-center py-10 text-zinc-400 text-sm">No resignation requests found.</div>
            </div>
        </div>
    </div>
</div>

<!-- Confirm Action Modal -->
<div id="confirmModalBg"
    class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center invisible opacity-0 transition-all duration-300">
    <div id="confirmModal"
        class="bg-white rounded-2xl p-7 w-full max-w-sm shadow-xl scale-95 opacity-0 transition-all duration-300">
        <div id="confirmIcon" class="w-12 h-12 rounded-full flex items-center justify-center mb-4"></div>
        <h2 id="confirmTitle" class="text-xl font-bold text-zinc-900 mb-1"></h2>
        <p id="confirmMessage" class="text-sm text-zinc-500 mb-6"></p>
        <div class="flex gap-3">
            <button onclick="closeConfirmModal()"
                class="flex-1 border border-zinc-300 text-zinc-600 text-sm font-medium py-2.5 rounded-lg hover:bg-zinc-100 transition-colors cursor-pointer">
                Cancel
            </button>
            <button id="confirmActionBtn"
                class="flex-1 text-white text-sm font-medium py-2.5 rounded-lg transition-colors cursor-pointer">
                Confirm
            </button>
        </div>
    </div>
</div>

<!-- View Letter Modal -->
<div id="letterModalBg"
    class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center invisible opacity-0 transition-all duration-300">
    <div id="letterModal"
        class="bg-white rounded-2xl p-7 w-full max-w-lg shadow-xl scale-95 opacity-0 transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-zinc-900">Resignation Letter</h2>
            <button onclick="closeLetterModal()" class="text-zinc-400 hover:text-zinc-700 cursor-pointer">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>
        <p id="letterContent" class="text-sm text-zinc-600 leading-relaxed whitespace-pre-wrap bg-zinc-50 rounded-xl p-4 max-h-64 overflow-y-auto"></p>
        <div class="mt-5 flex justify-end">
            <button onclick="closeLetterModal()"
                class="text-sm border border-zinc-300 text-zinc-600 rounded-lg px-4 py-2 hover:bg-zinc-100 transition-colors cursor-pointer">
                Close
            </button>
        </div>
    </div>
</div>

<script>
    async function loadRequests() {
        const res  = await fetch('../src/controllers/getResignationList.php');
        const data = await res.json();
        const tbody     = document.getElementById('resignationTableBody');
        const noResults = document.getElementById('noResults');

        if (data.length === 0) {
            noResults.classList.remove('hidden');
            return;
        }

        noResults.classList.add('hidden');
        tbody.innerHTML = data.map(r => {
            const name   = `${r.first_name} ${r.last_name}`;
            const status = parseInt(r.status);

            const statusBadge = status === 1
                ? `<span class="bg-green-100 text-green-700 text-xs font-medium px-2.5 py-1 rounded-full">Approved</span>`
                : status === 2
                ? `<span class="bg-red-100 text-red-600 text-xs font-medium px-2.5 py-1 rounded-full">Rejected</span>`
                : `<span class="bg-yellow-100 text-yellow-700 text-xs font-medium px-2.5 py-1 rounded-full">● Pending</span>`;

            const actionBtns = status === 0
                ? `<div class="flex gap-2">
                        <button onclick="openConfirmModal(${r.resign_id}, 1)"
                            class="bg-green-500 hover:bg-green-600 text-white text-xs px-3 py-1 rounded-md transition-colors cursor-pointer">
                            Approve
                        </button>
                        <button onclick="openConfirmModal(${r.resign_id}, 2)"
                            class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded-md transition-colors cursor-pointer">
                            Decline
                        </button>
                   </div>`
                : `<span class="text-xs text-zinc-400 italic">No action needed</span>`;

            return `
                <tr class="border-b border-zinc-50 hover:bg-zinc-50 transition-colors">
                    <td class="py-3 pr-6">
                        <div class="flex items-center gap-3">
                            <img src="${r.profile_link}" alt="${name}"
                                class="w-9 h-9 rounded-md object-cover shadow-sm">
                            <span class="text-zinc-800 font-medium">${name}</span>
                        </div>
                    </td>
                    <td class="py-3 pr-6 text-zinc-600">${r.position_name ?? '—'}</td>
                    <td class="py-3 pr-6">${statusBadge}</td>
                    <td class="py-3 pr-6">
                        <button onclick="viewLetter('${encodeURIComponent(r.resignation_letter)}')"
                            class="text-sky-600 hover:underline text-xs cursor-pointer">
                            Download File
                        </button>
                    </td>
                    <td class="py-3">${actionBtns}</td>
                </tr>
            `;
        }).join('');
    }

    async function handleAction(id, choice) {
        const fd = new FormData();
        fd.append('id', id);
        fd.append('choice', choice);
        await fetch('../src/controllers/approveNdecline.php', { method: 'POST', body: fd });
        closeConfirmModal();
        loadRequests();
    }

    function openConfirmModal(id, choice) {
        const isApprove = choice === 1;

        document.getElementById('confirmIcon').className = `w-12 h-12 rounded-full flex items-center justify-center mb-4 ${isApprove ? 'bg-green-100' : 'bg-red-100'}`;
        document.getElementById('confirmIcon').innerHTML = isApprove
            ? `<i class="fa-solid fa-check text-green-600 text-lg"></i>`
            : `<i class="fa-solid fa-xmark text-red-500 text-lg"></i>`;

        document.getElementById('confirmTitle').textContent = isApprove ? 'Approve Resignation' : 'Decline Resignation';
        document.getElementById('confirmMessage').textContent = isApprove
            ? 'Are you sure you want to approve this resignation request? This action cannot be undone.'
            : 'Are you sure you want to decline this resignation request? This action cannot be undone.';

        const btn = document.getElementById('confirmActionBtn');
        btn.className = `flex-1 text-white text-sm font-medium py-2.5 rounded-lg transition-colors cursor-pointer ${isApprove ? 'bg-green-500 hover:bg-green-600' : 'bg-red-500 hover:bg-red-600'}`;
        btn.textContent = isApprove ? 'Approve' : 'Decline';
        btn.onclick = () => handleAction(id, choice);

        showModal('confirmModalBg', 'confirmModal');
    }
    function closeConfirmModal() { hideModal('confirmModalBg', 'confirmModal'); }

    function viewLetter(encoded) {
        document.getElementById('letterContent').textContent = decodeURIComponent(encoded);
        showModal('letterModalBg', 'letterModal');
    }
    function closeLetterModal() { hideModal('letterModalBg', 'letterModal'); }

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

    loadRequests();
</script>
</body>
</html>
