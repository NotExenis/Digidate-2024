<?php

function newmessage(){
    include 'private/conn.php';
    require "succesmessage.php";
    if(isset($_SESSION['notification'])) {
        $error = $_SESSION['notification'];
        succesmessage($error);
        unset($_SESSION['notification']);
    }

    $userID = $_SESSION['users_id'];
    $read = "0";
    $sql = "SELECT COUNT(*) AS message_count
            FROM tbl_messages
            WHERE messages_read = :messages_read AND messages_reciever = :users_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":messages_read", $read);
    $stmt->bindParam(":users_id", $userID);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['message_count'] > 0) {
        $_SESSION['notification'] = "You have new message!";

    }
}

