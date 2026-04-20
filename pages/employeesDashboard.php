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
</body>

<script>
    console.log("<?=$fullName?>");
</script>
</html>