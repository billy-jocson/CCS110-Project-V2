<?php
    // File resignation code here
    include("../controllers/submitResignation.php");
    session_start();
    $employee_id = $_SESSION['employee_id'];
    $fullName = $_SESSION["fullName"];
    $isAdmin = $_SESSION["isAdmin"];
    $position = $_SESSION['position'];
    $is_paid = $_SESSION['is_paid']; //if not paid, then employee cannot file resignation or something ganon
    $employee_id = $_SESSION['employee_id'];
        
?>

<div>
    <h2>Submit Resignation</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="employee_id" value="<?php echo $employee_id; ?>">
        <label for="resignation_letter">Resignation Letter:</label><br>
        <input type="file" name="resignation_letter" id="resignation_letter" required><br><br>
        <label for="desired_date">Desired Last Working Day:</label><br>
        <input type="date" name="desired_date" id="desired_date" required><br><br>
        <button type="submit">Submit Resignation</button>
    </form>
</div>