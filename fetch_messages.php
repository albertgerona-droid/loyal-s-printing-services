<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />

<?php
include '../config.php';

// Logged-in user
$user_idko = $_SESSION['active_login'] ?? '';

$get_branch = $conn->prepare("SELECT * FROM `accounts` WHERE `user_id` != ?");
$get_branch->bind_param("s",$user_idko);
$get_branch->execute();
$result_get = $get_branch->get_result();

if($result_get->num_rows>0){
    while($row_get = mysqli_fetch_assoc($result_get)){
        $branch_name = htmlspecialchars($row_get['branch_name']);
        $user_id = htmlspecialchars($row_get['user_id']);
        $seen = 'no';

        $get_message = $conn->prepare("
            SELECT COUNT(*) as total_message 
            FROM `messages` 
            WHERE `user_id` = ? AND `receiver` = ? AND `seen` = ?
        ");
        $get_message->bind_param("sss",$user_id,$user_idko,$seen);
        $get_message->execute();
        $result_execute = $get_message->get_result();
        $total_message = 0;
        if($row_count = mysqli_fetch_assoc($result_execute)){
            $total_message = (int)$row_count['total_message'];
        }
        ?>

        <a href="message_modal.php?user_id=<?= $user_id ?>" class="btn border border-secondary p-3 shadow-sm text-start mb-3 w-100 d-flex justify-content-between align-items-center">
            <span><?= $branch_name ?></span>
            <?php if($total_message > 0): ?>
                <span class="badge bg-danger rounded-pill"><?= $total_message ?></span>
            <?php endif; ?>
        </a>

        <?php
    }
}else{
    echo "<p>No branches found.</p>";
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
