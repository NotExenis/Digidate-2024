<?php

include 'private/conn.php';

$sql_admin_select = "SELECT users_first_name, users_last_name, users_date_of_birth, users_id FROM tbl_users";
//$sql_admin_select = "SELECT users_id, users_first_name, users_preposition, users_last_name, users_email, users_is_admin, users_creation_date FROM tbl_users WHERE users_is_admin = 1 ";
$sth_admin_select = $db->prepare($sql_admin_select);
$sth_admin_select->execute();

while($row = $sth_admin_select->fetch()) {
    $datetime = new DateTime($row['users_date_of_birth']);
    $year = $datetime->format('Y');
    $username = substr($row['users_first_name'], 0, 1) . '.' . $row['users_last_name'] . $year;


    $sql_username_insert = 'UPDATE tbl_users SET users_username = :username WHERE users_id = :user_id';
    $sth_username_insert = $db->prepare($sql_username_insert);
    $sth_username_insert->bindParam(":user_id", $row['users_id']);
    $sth_username_insert->bindParam(":username", $username);

    $sth_username_insert->execute();

}