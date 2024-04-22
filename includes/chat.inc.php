<?php
include 'private/conn.php';

$userID = $_SESSION['users_id'];
$id = $_GET['id'];
$read = 1;

$sql = "SELECT m.messages_sender , m.messages_message, m.messages_datetime, m.messages_reciever, u.users_username
        FROM tbl_messages m
        INNER JOIN tbl_users u ON m.messages_sender = u.users_id
        WHERE  m.messages_reciever = :reciever_id OR m.messages_reciever = :users_id 
        ORDER BY m.messages_datetime ASC";
$stmt = $db->prepare($sql);
$stmt->bindParam(":reciever_id", $id);
$stmt->bindParam(":users_id", $userID);
$stmt->execute();
$messages = $stmt->fetchAll();

$sql2 = "UPDATE tbl_messages 
                    SET messages_read = :messages_read
                    WHERE messages_reciever = :messages_reciever";
$stmt2 = $db->prepare($sql2);
$stmt2->bindParam(":messages_read", $read);
$stmt2->bindParam(":messages_reciever", $userID);
$stmt2->execute();

?>
<style>
    .message-container {
        max-height: 70vh;
        overflow-y: auto;
        padding: 10px;
    }
</style>
<script>
    $(document).ready(function () {
        var messageContainer = document.getElementById('message-container');
        messageContainer.scrollTop = messageContainer.scrollHeight;
    });
</script>
<div class="page-content page-container" id="page-content">
    <div class="padding">
        <div class="row container d-flex justify-content-center">
            <div class="col-2"></div>
            <div class="col-6">
                <div class="card card-bordered">
                    <div class="card-header">
                        <h4 class="card-title"><strong>Chat</strong></h4>
                    </div>
                    <div class="message-container" id="message-container">
                        <?php
                        foreach ($messages as $message) {
                            if ($message['messages_reciever'] == $userID) { ?>
                                <div class="container">
                                    <p align="left"><strong><?= $message['users_username'] ?>
                                            :</strong> <?= $message['messages_message'] ?></p>
                                    <p align="left"><small><?= $message['messages_datetime'] ?></small></span></p>
                                </div>
                            <?php }
                            if ($message['messages_reciever'] != $userID) { ?>
                                <div class="darker container">
                                    <p align="right"><strong><?= $message['users_username'] ?>
                                            :</strong> <?= $message['messages_message'] ?></p>
                                    <p align="right"><small><?= $message['messages_datetime'] ?></small></span></p>
                                </div>
                            <?php }
                        } ?>
                    </div>
                    <form action="php/chat.php" method="POST">
                        <div class="p-3" id="chat">
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="chat_message" placeholder="Type a message"
                                   aria-label="Recipient's username" aria-describedby="basic-addon2" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" value="<?= $id ?>" name="id" type="submit">
                                    Button
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <div class="col-8"></div>
    </div>
</div>
</div>
