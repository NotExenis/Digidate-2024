<?php


require '../../private/conn.php';
include '../audit_trail.php';

session_start();

if(isset($_POST['user_edit'])) {
    foreach($_POST as $input) {
        if($input = 'user_edit') {

        }
    }
}

function editProfile($column, $value, $user_id) {

    $sql_admin_insert = 'UPDATE tbl_users SET '  . $column . ' = :value WHERE users_id = :users_id';
    $sth_admin_insert = $db->prepare($sql_admin_insert);
    $sth_admin_insert->bindParam(":value", $value);
    $sth_admin_insert->bindParam(":users_id", $user_id);

    $sth_admin_insert->execute();
    header('Location: ../../index.php?page=profile_users_edit');

}