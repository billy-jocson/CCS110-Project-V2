<?php
    include('../../backend/database.php');
?>

<table border = "1">
    <thead>
        <tr>
            <th>resign_id</th>
            <th>employee_id</th>
            <th>resignation_letter</th>
            <th>request_date</th>
            <th>desired_date</th>
            <th>status</th>
            <th>actions</th>
        </tr>
    </thead>
    <tbody id="ADemployee">
        <?php include("../controllers/getResignationRequest.php"); ?>
    </tbody>
</table>

<script src="../controllers/script.js"></script>