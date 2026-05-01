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
    <title>Payroll History</title>
    <?php include('../assets/fonts/fonts.php'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <script src="../assets/css/tailwindcss.js"></script>
    <style>
        * {
            font-family: 'DM Sans', sans-serif;
            scrollbar-width: thin;
        }
    </style>
</head>

<body>
    <div class="flex relative bg-zinc-100">
        <?php include '../src/components/sideBar.php'; ?>

        <div class="w-full md:flex-1 min-h-screen md:static md:overflow-y-auto">
            <div class="h-full flex flex-col p-10">
                <div class="h-fit mb-auto">
                    <?php
                    include("../src/controllers/getPayrollHistory.php");
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>