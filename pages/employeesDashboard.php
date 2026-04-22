<?php
session_start();
// session_destroy();
// exit;
if (!isset($_SESSION['fullName'])) {
    header('Location: ../login.php');
}

$fullName = $_SESSION["fullName"];
$isAdmin = $_SESSION["isAdmin"];
$position = $_SESSION['position'];
$is_paid = $_SESSION['is_paid'];
$employee_id = $_SESSION['employee_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Hello Employee! <?= $fullName?></h1>
    <a href="../src/controllers/logoutSession.php">
        Log Out
    </a>
    <!-- section na mag didisplay kung ung payslip ba ay paid or not paid -->
    <div>
        <h2>Position: <?= $position ?></h2>
        <h2>Payslip Status: <?= $is_paid ? 'Paid' : 'Not Paid' ?></h2>
    </div>
</body>

<script>
    console.log("<?=$fullName?>");
    console.log("<?=$is_paid?>");
</script>
</html>