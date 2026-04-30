<?php
$currentPage = basename($_SERVER['PHP_SELF']);

function isActive($page, $currentPage)
{
    return $page === $currentPage
        ? "bg-sky-600 text-white font-bold px-3 py-2 rounded-lg"
        : "text-zinc-600 hover:bg-zinc-100 px-3 py-2 rounded-lg";
}

function iconFill($page, $currentPage)
{
    return $page === $currentPage ? "fill-white" : "fill-zinc-600";
}

function iconStroke($page, $currentPage)
{
    return $page === $currentPage ? "stroke-white" : "stroke-zinc-600";
}
?>

<style>
    @media (max-width: 768px) {
        #sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }

        #sidebar.show {
            transform: translateX(0);
        }

        #sidebarOverlay {
            transition: opacity 0.3s ease-in-out;
            opacity: 0;
            pointer-events: none;
        }

        #sidebarOverlay.show {
            opacity: 1;
            pointer-events: auto;
        }

        #sidebarToggle {
            transition: all 0.3s ease-in-out;
        }

        #sidebarToggle.open i {
            transform: rotate(90deg);
        }
    }
</style>

<div class="flex">
    <!-- Sidebar -->
    <div id="sidebar"
        class="md:flex bg-white shadow-sm min-h-screen w-80 md:w-96 p-10 overflow-hidden flex-col sticky top-0 left-0 z-50 fixed md:static md:max-w-96 flex-col">
        <div class="w-full">
            <img src="../assets/images/PayFlow Logo.png" alt="PayFlow Logo" class="w-20 h-32 object-cover">
            <h1 class="text-2xl font-bold">PayFlow</h1>
        </div>
        <hr class="my-7 text-zinc-300">

        <nav class="flex flex-col text-sm">
            <ul class="flex flex-col gap-2">
                <small>Services</small>

                <!-- Dashboard -->
                <li>
                    <a href="dashboard.php"
                        class="flex gap-2 items-center transition-all duration-300 <?php echo isActive('dashboard.php', $currentPage); ?>">
                        <i
                            class="fa-solid fa-house <?php echo $currentPage == 'dashboard.php' ? 'text-white' : 'text-zinc-600'; ?>"></i>
                        Dashboard
                    </a>
                </li>
                <!-- Payroll -->
                <li>
                    <a href="payroll.php"
                        class="flex gap-2 items-center transition-all duration-300 <?php echo isActive('payroll.php', $currentPage); ?>">
                        <i
                            class="fa-solid fa-dollar-sign <?php echo $currentPage == 'payroll.php' ? 'text-white' : 'text-zinc-600'; ?>"></i>
                        Payroll
                    </a>
                </li>

                <li>
                    <a href="payrollHistory.php"
                        class="flex gap-2 items-center transition-all duration-300 <?php echo isActive('payrollHistory.php', $currentPage); ?>">
                        <i
                            class="fa-solid fa-clipboard-list <?php echo $currentPage == 'payrollHistory.php' ? 'text-white' : 'text-zinc-600'; ?>"></i>
                        Payroll History
                    </a>
                </li>
                <!-- Employees NavLinks -->
                <?php if ($isAdmin == 0): ?>
                    <!-- Payroll History -->

                    <!-- Request Resignation -->
                    <li>
                        <a href="requestResignation.php"
                            class="flex gap-2 items-center transition-all duration-300 <?php echo isActive('requestResignation.php', $currentPage); ?>">
                            <i
                                class="fa-solid fa-pen-nib <?php echo $currentPage == 'requestResignation.php' ? 'text-white' : 'text-zinc-600'; ?>"></i>
                            Request Resignation
                        </a>
                    </li>
                <?php endif ?>

                <!-- Employees NavLinks -->
                <?php if ($isAdmin == 1): ?>
                    <li>
                        <a href="employees.php"
                            class="flex gap-2 items-center transition-all duration-300 <?php echo isActive('employees.php', $currentPage); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-5 <?php echo $currentPage == 'employees.php' ? 'stroke-white' : 'stroke-zinc-600'; ?>">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                            </svg>
                            Employees
                        </a>
                    </li>
                    <li>
                        <a href="resignationRequests.php"
                            class="flex gap-2 items-center transition-all duration-300 <?php echo isActive('resignationRequests.php', $currentPage); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-5 <?php echo $currentPage == 'resignationRequests.php' ? 'stroke-white' : 'stroke-zinc-600'; ?>">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                            </svg>
                            Resignation Requests
                        </a>
                    </li>
                <?php endif ?>
                <li>
                    <a href="../src/controllers/logoutSession.php"
                        class=" text-red-600 hover:bg-zinc-100 px-3 py-2 rounded-lg flex gap-2 items-center transition-all duration-300">
                        <i class="fa-solid fa-arrow-right-from-bracket fill-red-600"></i>

                        Log Out
                    </a>
                </li>
            </ul>
        </nav>
        <div class="mt-auto flex items-center gap-3 w-10 object-cover aspect-square">
            <img src="<?php echo $_SESSION['profileLink'] ?>" alt="<?php echo $fullName . "Profile Picture" ?>"
                class="object-cover aspect-square shadow-md rounded-md">
            <div class="hidden md:block">
                <h1 class="font-bold text-sm w-100"><?php echo $fullName ?></h1>
                <h1 class="text-xs">Employee ID: <?php echo $_SESSION['position'] ?></h1>
            </div>
        </div>
    </div>

    <!-- Mobile Toggle Button -->
    <button id="sidebarToggle" class="md:hidden fixed top-4 left-4 z-40 p-2 bg-sky-600 text-white rounded-lg">
        <i class="fa-solid fa-bars text-xl transition-transform duration-300"></i>
    </button>

    <!-- Overlay for mobile -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 md:hidden z-40 transition-opacity duration-300"
        onclick="closeSidebar();">
    </div>
</div>

<script>
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    function closeSidebar() {
        sidebar.classList.remove('show');
        sidebarOverlay.classList.remove('show');
        sidebarToggle.classList.remove('open');
    }

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');
            sidebarToggle.classList.toggle('open');
        });

        // Close sidebar when a link is clicked
        sidebar.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                closeSidebar();
            });
        });
    }
</script>