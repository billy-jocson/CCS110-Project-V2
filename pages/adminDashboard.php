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
    <div class="flex h-screen overflow-hidden">
        <?php include('../src/components/sideBar.php'); ?>
        <div class="pt-10 px-10 bg-zinc-100 w-full flex-1 overflow-y-auto">
            <h1 class="font-bold text-3xl text-zinc-900">
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
            <h1 class="mt-2 text-zinc-900">Here's what we have for you today.</h1>

            <!-- User Profile Image -->
            <div class="flex flex-col gap-5">
                <div class="flex flex-col xl:flex-row gap-5 mt-5">
                    <div
                        class="bg-white relative aspect-square w-full xl:w-64 h-72 xl:h-64 rounded-2xl overflow-hidden">
                        <img src="<?php echo $_SESSION['profileLink'] ?>"
                            alt="<?php echo "$fullName Profile Picture" ?>"
                            class="w-full h-full object-cover aspect-square">
                        <div
                            class="absolute bottom-3 left-3 right-3 h-fit backdrop-blur-[3px] bg-white/50 px-4 py-3 rounded-xl">
                            <h1 class="text-zinc-950 font-semibold leading-tight">
                                <?php echo $fullName ?>
                            </h1>
                            <h1 class="text-zinc-950 text-sm opacity-90">
                                <?php echo $position ?>
                            </h1>
                        </div>
                    </div>


                    <div class="bg-white w-full p-3 rounded-lg">
                        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4 h-full">
                            <?php include('../src/components/companyMoney.php'); ?>
                            <?php include('../src/components/avgCompanyPayroll.php'); ?>
                            <?php include('../src/components/totalEmployees.php') ?>
                        </div>
                    </div>
                </div>
                <?php
                include('../src/components/employeesTable.php');
                include('../src/components/depositModal.php');
                ?>
            </div>
        </div>
    </div>
    <?php
    include('../src/components/employeeModal.php');
    ?>
</body>

</html>