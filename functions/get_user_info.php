<?php

function GetUserInfo($user_id) {
    require 'private/conn.php';

    $sql_user_info = "SELECT users_id, users_first_name, users_preposition, users_last_name, users_username, users_date_of_birth, users_city FROM tbl_users WHERE users_id = :user_id";
//$sql_user_info = "SELECT users_id, users_first_name, users_preposition, users_last_name, users_email, users_is_admin, users_creation_date FROM tbl_users WHERE users_is_admin = 1 ";
    $sth_user_info = $db->prepare($sql_user_info);
    $sth_user_info->bindParam(':user_id', $user_id);
    $sth_user_info->execute();
    $user_info = $sth_user_info->fetch();
    return $user_info;
}