<div class="bg-white shadow-sm min-h-screen w-96 p-10 overflow-hidden flex flex-col sticky top-0 left-0 z-50">
    <div class="w-full">
        <img src="../assets/images/PayFlow Logo.png" alt="PayFlow Logo" class="w-20 h-32 object-cover">
        <h1 class="text-2xl font-bold">PayFlow</h1>
    </div>
    <hr class="my-7 text-zinc-300">

    <nav class="flex flex-col text-sm">
        <ul class="flex flex-col gap-2">
            <small>Services</small>
            <li>
                <a onclick="" class="flex gap-2 items-center transition-all duration-300 
                    <?php if (basename($_SERVER['PHP_SELF']) == "adminDashboard.php")
                        echo "bg-sky-600 px-3 py-2 text-white rounded-lg font-bold"; ?>">

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-6 <?php if (basename($_SERVER['PHP_SELF']) == "adminDashboard.php")
                        echo "fill-white"; ?>">
                        <path
                            d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                        <path
                            d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                    </svg>
                    Dashboard
                </a>
            </li>
            <li>
                <a onclick="" href="../src/components/employeesPayrollTable.php"
                    class="text-zinc-600 hover:bg-zinc-100 px-3 py-2 rounded-lg flex gap-2 items-center transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-6 fill-zinc-600">
                        <path
                            d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 0 1-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004ZM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 0 1-.921.42Z" />
                        <path fill-rule="evenodd"
                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v.816a3.836 3.836 0 0 0-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 0 1-.921-.421l-.879-.66a.75.75 0 0 0-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 0 0 1.5 0v-.81a4.124 4.124 0 0 0 1.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 0 0-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 0 0 .933-1.175l-.415-.33a3.836 3.836 0 0 0-1.719-.755V6Z"
                            clip-rule="evenodd" />
                    </svg>

                    Payroll
                </a>
            </li>
            <li>
                <a onclick="changePage()" href = "../src/components/payrollHistory.php"
                    class="text-zinc-600 hover:bg-zinc-100 px-3 py-2 rounded-lg flex gap-2 items-center transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 stroke-zinc-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605" />
                    </svg>

                    Payroll History
                </a>
            </li>
            <li>
                <a href="../src/components/fileResignation.php"
                    class="hover:text-zinc-800  text-zinc-600 hover:bg-zinc-100 px-3 py-2 rounded-lg flex gap-2 items-center transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 stroke-zinc-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                    </svg>
                    Request Resignation
                </a>
            </li>
            <li>
                <a href="../src/components/resignationRequest.php"
                    class="hover:text-zinc-800  text-zinc-600 hover:bg-zinc-100 px-3 py-2 rounded-lg flex gap-2 items-center transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 stroke-zinc-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                    Employees
                </a>
            </li>
            <li>
                <a href="../src/components/resignationRequest.php"
                    class="hover:text-zinc-800  text-zinc-600 hover:bg-zinc-100 px-3 py-2 rounded-lg flex gap-2 items-center transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 stroke-zinc-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                    </svg>
                    Resignation Requests
                </a>
            </li>
            <li>
                <a href="../src/controllers/logoutSession.php"
                    class=" text-red-600 hover:bg-zinc-100 px-3 py-2 rounded-lg flex gap-2 items-center transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-6 fill-red-600">
                        <path fill-rule="evenodd"
                            d="M7.5 3.75A1.5 1.5 0 0 0 6 5.25v13.5a1.5 1.5 0 0 0 1.5 1.5h6a1.5 1.5 0 0 0 1.5-1.5V15a.75.75 0 0 1 1.5 0v3.75a3 3 0 0 1-3 3h-6a3 3 0 0 1-3-3V5.25a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3V9A.75.75 0 0 1 15 9V5.25a1.5 1.5 0 0 0-1.5-1.5h-6Zm5.03 4.72a.75.75 0 0 1 0 1.06l-1.72 1.72h10.94a.75.75 0 0 1 0 1.5H10.81l1.72 1.72a.75.75 0 1 1-1.06 1.06l-3-3a.75.75 0 0 1 0-1.06l3-3a.75.75 0 0 1 1.06 0Z"
                            clip-rule="evenodd" />
                    </svg>

                    Log Out
                </a>
            </li>
        </ul>
    </nav>
    <div class="mt-auto flex items-center gap-3 w-10 object-cover aspect-square">
        <img src="<?php echo $_SESSION['profileLink'] ?>" alt="<?php echo $fullName . "Profile Picture" ?>"
            class="object-cover aspect-square shadow-md rounded-md">
        <div>
            <h1 class="font-bold w-96"><?php echo $fullName ?></h1>
            <h1 class="text-xs"><?php echo $_SESSION['position'] ?></h1>
        </div>
    </div>
</div>
<script>
    function changePage(removePage, addPage) {
        removePage.remove();
        addPage.add();
    }
</script>