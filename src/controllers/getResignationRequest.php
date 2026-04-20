<?php

    $resignation = mysqli_query($conn, "SELECT * FROM resignation_request");

    while($row = mysqli_fetch_assoc($resignation)){
        echo '
            <tr>
                <td>' . $row["resign_id"] . '</td>
                <td>' . $row["employee_id"] . '</td>
                <td>' . $row["resignation_letter"] . '</td>
                <td>' . $row["request_date"] . '</td>
                <td>' . $row["desired_date"] . '</td>
                <td>' . $row["status"] . '</td>
                <td>
                    <button class="aproveBtn" data-id="' . $row["resign_id"] . '">Approve</button>
                    <button class="declineBtn" data-id="' . $row["resign_id"] . '">Decline</button>
                </td>
            </tr>
        ';
    }
    
    $result = mysqli_query($conn, "SELECT * FROM resignation_request WHERE status != 1");
    echo json_encode($result);
    
?>