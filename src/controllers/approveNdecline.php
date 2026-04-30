<<<<<<< HEAD
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
=======
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
>>>>>>> c282d3b091bf6f3005d7ecc2311a5d95b4063715
?>