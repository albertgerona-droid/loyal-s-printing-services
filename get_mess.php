<?php
include '../config.php';


$my_id = $_SESSION['active_login'] ?? '';
$chat_with = $_GET['user_id'] ?? '';

if (!$chat_with || !$my_id) exit;

// Fetch messages between the two users
$get_message = $conn->prepare("
    SELECT * FROM messages 
    WHERE (user_id = ? AND receiver = ?) 
       OR (user_id = ? AND receiver = ?) 
    ORDER BY date_sent,time_sent ASC
");
$get_message->bind_param("ssss", $my_id, $chat_with, $chat_with, $my_id);
$get_message->execute();
$result_message = $get_message->get_result();
?>

<style>
.chat-container {
    max-width: 700px;
    margin: 20px auto;
    padding: 10px;
    font-family: Arial, sans-serif;
}
.message {
    display: flex;
    margin: 10px 0;
}
.message.left {
    justify-content: flex-start;
}
.message.right {
    justify-content: flex-end;
}
.msg-content {
    max-width: 70%;
    padding: 12px 16px;
    border-radius: 20px;
    position: relative;
    word-wrap: break-word;
}
.message.left .msg-content {
    background-color: #f1f0f0;
    color: #333;
    border-top-left-radius: 0;
}
.message.right .msg-content {
    background-color: #4f93ff;
    color: white;
    border-top-right-radius: 0;
}
.msg-time {
    font-size: 0.75rem;
    margin-top: 4px;
    text-align: right;
    opacity: 0.7;
}
</style>

<div class="chat-container">
<?php
while ($row_mess = $result_message->fetch_assoc()) {
    $message = htmlspecialchars($row_mess['message']);
    $time_sent = htmlspecialchars($row_mess['time_sent']);
    $sender_id = $row_mess['user_id'];

    $side_class = ($sender_id == $my_id) ? 'right' : 'left';
    ?>
    <div class="message <?= $side_class ?>">
        <div class="msg-content">
            <?= nl2br($message) ?>
            <div class="msg-time"><?= $time_sent ?></div>
        </div>
    </div>
<?php
}
?>
</div>
