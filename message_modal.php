<?php
include 'messages.php'; 

$user_id = $_GET['user_id'] ?? '';

$branch_name = '';
$get_info = $conn->prepare("SELECT branch_name FROM accounts WHERE user_id = ?");
$get_info->bind_param("s", $user_id);
$get_info->execute();
$result_get = $get_info->get_result();

if ($row = $result_get->fetch_assoc()) {
    $branch_name = htmlspecialchars($row['branch_name']);
}


if($user_id){
    $update = $conn->prepare("
        UPDATE `messages` 
        SET `seen` = ? 
        WHERE `receiver` = ? AND `user_id` = ?
    ");
    $update->bind_param("sss", $yes, $_SESSION['active_login'], $user_id);
    $update->execute();

   
}
?>

<style>
.main_message{
    height: 50vh;
    border:1px dashed black;
    overflow-y: auto;
}
</style>

<form id="sendMessageForm">
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header border-0">
                    <h1 class="modal-title fs-5"><?= $branch_name ?></h1>
                    <button type="button" onclick="location.href='messages.php'" class="btn-close"></button>
                    <input type="hidden" name="user_id" value="<?= $user_id ?>">
                </div>

                <div class="modal-body">
                    <div class="main_message"></div>
                </div>

                <div class="modal-footer">
                    <div class="d-flex w-100 gap-1">
                        <input type="text" class="form-control" name="message_text" required>
                       <button class="btn" type="submit" name="sent_message">
    <img src="../image/send.png" alt="">
</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</form>

<script>
const USER_ID = "<?= $user_id ?>";

$(document).ready(function () {

    $('#staticBackdrop').modal('show');

    function loadMessages() {
        $.ajax({
            url: 'get_mess.php',
            type: 'GET',
            data: { user_id: USER_ID },
            success: function (data) {
                $('.main_message').html(data);
                $('.main_message').scrollTop($('.main_message')[0].scrollHeight);
            }
        });
    }

    // Load messages immediately
    loadMessages();

    // Poll every 2 seconds
    setInterval(loadMessages, 2000);

    // Send message via AJAX
  $('#sendMessageForm').on('submit', function(e){
    e.preventDefault();
    $.ajax({
        url: 'function.php',
        type: 'POST',
        data: $(this).serialize(),
        success: function(res){
            $('input[name="message_text"]').val(''); // clear input
            loadMessages(); // refresh messages
        }
    });
});


});
</script>
