<?php

require '../../private/conn.php';
include '../audit_trail.php';


if(isset($_POST['admin_add'])) {
    AdminAdd($_POST['first_name'], $_POST['preposition'], $_POST['last_name'], $_POST['email']);
}
if(isset($_POST['admin_delete'])) {
    //print_r($_POST);
    AdminDelete($_POST['admin_delete']);
}
if(isset($_POST['admin_edit'])) {
    //print_r($_POST);
    Audit_AdminUpdate($_POST);
    AdminEdit($_POST['users_first_name'], $_POST['users_preposition'], $_POST['users_last_name'], $_POST['users_id']);

}

//Inserts new admin with a value of users_is_admin with a value of 1;

function AdminAdd($first_name, $preposition, $last_name, $email) {

    $password_user = password_hash("password", PASSWORD_DEFAULT);
    include '../../private/conn.php';

    $sql_admin_insert = 'INSERT INTO tbl_users (users_first_name, users_preposition, users_last_name, users_email, users_password, users_is_admin) VALUES (:first_name, :preposition, :last_name, :email, :password, 1)';
    $sth_admin_insert = $db->prepare($sql_admin_insert);
    $sth_admin_insert->bindParam(":first_name", $first_name);
    $sth_admin_insert->bindParam(":preposition", $preposition);
    $sth_admin_insert->bindParam(":last_name", $last_name);
    $sth_admin_insert->bindParam(":email", $email);
    $sth_admin_insert->bindParam(":password", $password_user);

    $sth_admin_insert->execute();
    header('Location: ../../index.php?page=admin_table');

}

function AdminEdit($first_name, $preposition, $last_name, $user_id) {

    include '../../private/conn.php';

    $sql_admin_insert = 'UPDATE tbl_users SET users_first_name = :first_name, users_preposition = :preposition, users_last_name = :last_name WHERE users_id = :users_id';
    $sth_admin_insert = $db->prepare($sql_admin_insert);
    $sth_admin_insert->bindParam(":first_name", $first_name);
    $sth_admin_insert->bindParam(":preposition", $preposition);
    $sth_admin_insert->bindParam(":last_name", $last_name);
    $sth_admin_insert->bindParam(":users_id", $user_id);

    $sth_admin_insert->execute();
    //header('Location: ../../index.php?page=admin_table');

}
function AdminDelete($admin_id) {
    include '../../private/conn.php';

    $sql_admin_delete = 'DELETE FROM tbl_users WHERE users_id = :user_id';
    $sth_admin_delete = $db->prepare($sql_admin_delete);
    $sth_admin_delete->bindParam(":user_id", $_POST['admin_delete']);
    $sth_admin_delete->execute();
    header('Location: ../../index.php?page=admin_table');

}




//Selects the logged-in admin.
/*$sql_admin_select = "SELECT users_id FROM tbl_users WHERE users_is_admin = ". $_SESSION['role'] . " ";
$sth_admin_select = $db->prepare($sql_admin_select);
$sth_admin_select->execute();
$selected_admin = $sth_admin_select->fetchColumn();*/




