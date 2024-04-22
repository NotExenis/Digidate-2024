<?php
require "../private/conn.php";
session_start();

$message = $_POST['chat_message'];
$time = date("Y-m-d H:i:sa");
$userID = $_SESSION['users_id'];
$messages_reciever = $_POST['id'];



$sql = "INSERT INTO tbl_messages (messages_sender, messages_reciever, messages_message, messages_datetime)
        VALUES (:messages_sender, :messages_reciever, :messages_message, :messages_datetime)";
$stmt = $db->prepare($sql);
$stmt->bindParam(":messages_sender", $userID);
$stmt->bindParam(":messages_reciever", $messages_reciever);
$stmt->bindParam(":messages_message", $message);
$stmt->bindParam(":messages_datetime", $time);
$stmt->execute();
$messages = $stmt->fetchAll();

header('location: ../index.php?page=chat&id='.$messages_reciever);
