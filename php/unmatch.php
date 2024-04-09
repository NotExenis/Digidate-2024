<?php
include '../private/conn.php';
session_start();
var_dump($_POST);
var_dump($_SESSION['users_id']);
/*
$sql_unmatch = "SELECT * FROM `tbl_likes` 
                    WHERE (likes_liked_user = :current_user_id AND likes_current_user = :target_user_id) 
                       OR (likes_liked_user = :target_user_id AND likes_current_user = :current_user_id)";
$sth_unmatch = $db->prepare($sql_unmatch);
$sth_unmatch->bindParam(':current_user_id', $_SESSION['users_id']);
$sth_unmatch->bindParam(':target_user_id', $_POST['unmatch_user']);
$sth_unmatch->execute();
var_dump($sth_unmatch->fetchAll());*/
//header('Location:../index.php?page=matches_table');

$current_user_id = intval($_SESSION['users_id']);
$target_user_id = intval($_POST['unmatch_user']);

$sql_unmatch = "INSERT INTO tbl_unmatch (unmatch_user_id_unmatcher, unmatch_user_id_target) 
                       VALUES (:current_user_id, :target_user_id)";
$sth_unmatch = $db->prepare($sql_unmatch);
$sth_unmatch->bindParam(':current_user_id', $current_user_id);
$sth_unmatch->bindParam(':target_user_id', $target_user_id);
$sth_unmatch->execute();

$sql_update_like_1 = "UPDATE tbl_likes SET likes_is_unmatched = 1 WHERE likes_liked_user = :current_user_id AND likes_current_user = :target_user_id";
$sth_update_like_1 = $db->prepare($sql_update_like_1);
$sth_update_like_1->bindParam(':current_user_id', $current_user_id);
$sth_update_like_1->bindParam(':target_user_id', $target_user_id);
$sth_update_like_1->execute();


$sql_update_like_1 = "UPDATE tbl_likes SET likes_is_unmatched = 1 WHERE likes_liked_user = :target_user_id AND likes_current_user = :current_user_id";
$sth_update_like_1 = $db->prepare($sql_update_like_1);
$sth_update_like_1->bindParam(':current_user_id', $current_user_id);
$sth_update_like_1->bindParam(':target_user_id', $target_user_id);
$sth_update_like_1->execute();
header('Location:../index.php?page=matches_table');

