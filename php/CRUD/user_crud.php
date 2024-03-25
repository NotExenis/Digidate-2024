<?php


include '../audit_trail.php';

session_start();

if(isset($_POST['user_edit'])) {
    foreach($_POST as $input) {
        if($input = 'user_edit') {
            foreach($_POST as $key => $value) {
                $column = editProfile($key, $value, $_SESSION['users_id']);
            }
        }
    }
    header('Location: ../../index.php?page=profile_users_edit');

}

if(isset($_POST['uncheck_tags'])) {
    foreach($_POST['uncheck_tags'] as $tags) {
        removeTagsFromUser($tags, $_SESSION['users_id']);
    }
    header('Location: ../../index.php?page=profile_users_edit');
}

if(isset($_POST['chosen_tags'])) {
    foreach($_POST['chosen_tags'] as $tags) {
        //print_r($tags);
        addTagsToUser($tags, $_SESSION['users_id']);
    }
    header('Location: ../../index.php?page=profile_users_edit');
}


function editProfile($column, $value, $user_id) {
    require '../../private/conn.php';

    $sql_edit_profile = 'UPDATE tbl_users SET '  . $column . ' = :value WHERE users_id = :users_id';
    $sth_edit_profile = $db->prepare($sql_edit_profile);
    $sth_edit_profile->bindParam(":value", $value);
    $sth_edit_profile->bindParam(":users_id", $user_id);
    $sth_edit_profile->execute();

}

function addTagsToUser($tag_id, $user_id) {
    require '../../private/conn.php';

    $sql_add_tag = 'INSERT INTO tbl_usertags (usertags_tags_id, usertags_users_id) VALUES (:value, :user_id)';
    $sth_add_tag = $db->prepare($sql_add_tag);
    $sth_add_tag->bindParam(":value", $tag_id);
    $sth_add_tag->bindParam(":user_id", $user_id);
    $sth_add_tag->execute();
}

function removeTagsFromUser($tag_id, $user_id) {
    require '../../private/conn.php';

    $sql_usertags = "DELETE FROM tbl_usertags WHERE usertags_users_id = :user_id AND usertags_tags_id = :tag_id";
    $stmt_usertags = $db->prepare($sql_usertags);
    $stmt_usertags->bindParam(":user_id", $user_id);
    $stmt_usertags->bindParam(":tag_id", $tag_id);
    $stmt_usertags->execute();
    $usertags = $stmt_usertags->fetch(PDO::FETCH_ASSOC);
    return $usertags;
}