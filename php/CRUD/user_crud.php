<?php
include '../audit_trail.php';
session_start();
var_dump($_POST);
if(isset($_POST['user_edit'])) {
    //var_dump($_POST);
    foreach($_POST as $input) {
        if($input = 'user_edit') {
            unset($_POST['user_edit']);
            foreach($_POST as $key => $value) {
                $column = $key;
                editProfile($key, $value, $_SESSION['users_id']);
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

if( isset($_POST['getColor'])){
    $tag_id = $_POST['getColor'];
    $query = "SELECT * FROM tbl_tags WHERE tags_id=:tags_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':tags_id', $tag_id);
    if($stmt->execute()){
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tagcolor= $row['tags_color'];
            echo $tagcolor;
        }else {
            echo "error";
        }

    }else {
        echo "error";
    }
}

function CheckTags($user_id) {
    include '../../private/conn.php';

    $sql_usertags = "SELECT * FROM tbl_usertags WHERE usertags_users_id = :user_id";
    $stmt_usertags = $db->prepare($sql_usertags);
    $stmt_usertags->bindParam(":user_id", $_SESSION['users_id']);
    $stmt_usertags->execute();
    $usertags = $stmt_usertags->fetch(PDO::FETCH_ASSOC);
    return $usertags;
}

function editProfile($column, $value, $user_id) {
    require '../../private/conn.php';

    //Image Add
    if($_FILES['image']['tmp_name'][0] != NULL) {
        echo "ja";
        foreach ($_FILES['image']['tmp_name'] as $key => $tmp_name) {


            $pic = ($_FILES['image']['tmp_name'][$key]) ? base64_encode(file_get_contents($_FILES['image']['tmp_name'][$key])) : null;

            $sql_insert_photo = "INSERT INTO tbl_images (images_user_id, images_image) VALUES (:user_id, :image)";
            $stmt_insert_photo = $db->prepare($sql_insert_photo);
            $stmt_insert_photo->bindParam(":user_id", $_SESSION['users_id']);
            $stmt_insert_photo->bindParam(":image", $pic);
            $stmt_insert_photo->execute();
        }
    }

    $sql_edit_profile = 'UPDATE tbl_users SET '  . $column . ' = :value WHERE users_id = :users_id';
    $sth_edit_profile = $db->prepare($sql_edit_profile);
    $sth_edit_profile->bindParam(":value", $value);
    $sth_edit_profile->bindParam(":users_id", $user_id);
    $sth_edit_profile->execute();
}

function addTagsToUser($tag_id, $user_id) {
    require '../../private/conn.php';

    $check_tags = CheckTags($user_id);

    if(isset($check_tags)) {
        if (array_count_values($check_tags) >= 4) {
            $_SESSION['notification'] = 'You have tried to add more than the maximum of 5 tags.';
        }

    } else {

        $sql_add_tag = 'INSERT INTO tbl_usertags (usertags_tags_id, usertags_users_id) VALUES (:value, :user_id)';
        $sth_add_tag = $db->prepare($sql_add_tag);
        $sth_add_tag->bindParam(":value", $tag_id);
        $sth_add_tag->bindParam(":user_id", $user_id);
        $sth_add_tag->execute();
        $_SESSION['success'] = 'Succesfully added tags!';

    }

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