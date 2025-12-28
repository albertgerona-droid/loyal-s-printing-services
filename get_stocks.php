<?php
include '../config.php';

$count = $conn->prepare("SELECT * FROM `stocks` WHERE `user_id` = ?");
$count->bind_param("s", $user_idko);
$count->execute();

$result = $count->get_result();

$low_stock_count = 0; // counter

if ($result->num_rows > 0) {
    while ($get = $result->fetch_assoc()) {

        $data = [
            (int) ($get['laminating_plastic'] ?? 0),
            (int) ($get['long_bond_paper'] ?? 0),
            (int) ($get['photo_paper'] ?? 0),
            (int) ($get['short_bond_paper'] ?? 0),
            (int) ($get['a4_bond_paper'] ?? 0),
        ];

        foreach ($data as $all_data) {
            if ($all_data <= 50) {
                $low_stock_count++;
            }
        }
    }
}

?>

<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
    <?php  echo $low_stock_count ?? 0; ?>
  </span>


