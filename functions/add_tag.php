<?php
session_start();

function addTagsToUser($tag_id, $user_id) {
    require 'private/conn.php';
    $sql_add_tag = "UPDATE tbl_usertags SET usertags_tags_id = :value WHERE usertags_users_id = :users_id";
    $sth_add_tag = $db->prepare($sql_add_tag);
    $sth_add_tag->bindParam(":value", $tag_id);
    $sth_add_tag->bindParam(":users_id", $user_id);

    $sth_add_tag->execute();

}