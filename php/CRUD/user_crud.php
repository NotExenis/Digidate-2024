<?php


require '../../private/conn.php';
include '../audit_trail.php';

session_start();

if(isset($_POST['user_edit'])) {
    foreach($_POST as $input) {
        if($input = 'user_edit') {
            foreach($_POST as $key => $value) {
                $column =
                editProfile($key, $value, $_SESSION['users_id']);
            }
        }
    }
}

function editProfile($column, $value, $user_id) {

    $sql_edit_profile = 'UPDATE tbl_users SET '  . $column . ' = :value WHERE users_id = :users_id';
    $sth_edit_profile = $db->prepare($sql_edit_profile);
    $sth_edit_profile->bindParam(":value", $value);
    $sth_edit_profile->bindParam(":users_id", $user_id);

    $sth_edit_profile->execute();
    header('Location: ../../index.php?page=profile_users_edit');

}

function addTagsToUser($tag_id, $user_id) {
    $sql_add_tag = 'UPDATE tbl_usertags SET usertags_tags_id = :value WHERE usertags_users_id = :users_id';
    $sth_add_tag = $db->prepare($sql_add_tag);
    $sth_add_tag->bindParam(":value", $tag_id);
    $sth_add_tag->bindParam(":users_id", $user_id);

    $sth_add_tag->execute();
    header('Location: ../../index.php?page=profile_users_edit');

}