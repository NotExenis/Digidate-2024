<?php
include '../private/conn.php';
include '../functions/succesmessage.php';
include '../functions/errormessage.php';
include 'audit_trail.php';

if(isset($_SESSION['notification'])) {
    $error = $_SESSION['notification'];
    succesmessage($error);
    unset($_SESSION['notification']);
}

if (isset($_POST['tag_delete'])){
    $sql_tags_delete = 'DELETE FROM tbl_tags WHERE tags_id = :tags_id';
    $sth_tag_delete = $db->prepare($sql_tags_delete);
    $sth_tag_delete->bindParam(":tags_id", $_POST['tag_delete']);
    $sth_tag_delete->execute();
    header('Location: ../index.php?page=tag_table');
}

if (isset($_POST['tag_edit'])){

    Audit_TagUpdate($_POST);
    $sql_tags_insert = 'UPDATE tbl_tags SET tags_title = :tags_title, tags_color = :tags_color WHERE tags_id = :tags_id';
    $sth_tags_insert = $db->prepare($sql_tags_insert);
    $sth_tags_insert->bindParam(":tags_title", $_POST['tags_title']);
    $sth_tags_insert->bindParam(":tags_color", $_POST['tags_color']);
    $sth_tags_insert->bindParam(":tags_id", $_POST['tags_id']);

    $sth_tags_insert->execute();
    //header('Location: ../index.php?page=tag_table');
}