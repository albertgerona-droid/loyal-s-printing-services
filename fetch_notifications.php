<?php

include '../config.php';
$seen = 'no';
$get_images = $conn->prepare("SELECT COUNT(*) as `total_message` FROM `messages` WHERE `receiver` = ? AND `seen` = ?");
$get_images->bind_param("ss", $user_idko, $seen);
$get_images->execute();  
$result = $get_images->get_result(); 

if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $total_message = htmlspecialchars($row['total_message'] ?? 0);
    }
}
$display = ($total_message === "0") ? 'd-none' : '';
 echo " <span class='position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger $display'>$total_message</span>";

