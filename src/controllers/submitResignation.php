<?php
include('../../backend/database.php');
// dko knowd nangyari dto HAAAHHAA basta nagasya T-T 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id = $_POST['employee_id'];
    $desired_date = $_POST['desired_date'];
    
    $targetDir = "../upload/"; 

    if (isset($_FILES['resignation_letter']) && $_FILES['resignation_letter']['error'] === UPLOAD_ERR_OK) {
        
        $fileName = basename($_FILES['resignation_letter']['name']);
        $targetPath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['resignation_letter']['tmp_name'], $targetPath)) {
            $stmt = $conn->prepare("INSERT INTO resignation_request (employee_id, resignation_letter, desired_date, status) VALUES (?, ?, ?, 0)");
            $stmt->bind_param('iss', $employee_id, $targetPath, $desired_date);
            
            if ($stmt->execute()) {
                echo "Resignation submitted successfully.";
            } else {
                echo "Database Error: " . $stmt->error;
            }
        } else {
            echo "Error: Could not move the file to " . $targetPath;
        }
    } else {
        echo "Please select a valid file.";
    }
}
?>