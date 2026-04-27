<?php

    include("../../backend/database.php");
    switch($_POST["choice"]){
        case 1:
            $id = $_POST["id"];
            $result = mysqli_query($conn, "UPDATE resignation_request SET status = 1  WHERE resign_id = $id");
            break;
            
        case 2:
            $id = $_POST["id"];
            $result = mysqli_query($conn, "UPDATE resignation_request SET status = 2  WHERE resign_id = $id");
            break;
    }
?>