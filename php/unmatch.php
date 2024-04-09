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


$sql_unmatch = "INSERT INTO tbl_unmatch (unmatch_user_id_unmatcher, unmatch_user_id_target) 
                       VALUES (:current_user_id, :target_user_id)";
$sth_unmatch = $db->prepare($sql_unmatch);
$sth_unmatch->bindParam(':current_user_id', $_SESSION['users_id']);
$sth_unmatch->bindParam(':target_user_id', $_POST['unmatch_user']);
$sth_unmatch->execute();

