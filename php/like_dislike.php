<?php
require "../private/conn.php";
session_start();
$current_user = $_SESSION['users_id'];

$like = $_POST["user_id_like"];
$dislike = $_POST["user_id_dislike"];
if(isset($like)){
    $sql = "INSERT INTO tbl_likes (likes_liked_user, likes_current_user) VALUES (:user_id,:current_user)";
    $stmt = $db->prepare($sql);
    $stmt->execute(array(
        ':user_id' => $like,
        ':current_user' => $current_user
    ));
} else {
    $sql = "INSERT INTO tbl_dislikes (dislikes_disliked_user, dislikes_current_user) VALUES (:user_id,:current_user)";
    $stmt = $db->prepare($sql);
    $stmt->execute(array(
        ':user_id' => $dislike,
        ':current_user' => $current_user
    ));
}

header("Location:../index.php?page=profile_users");