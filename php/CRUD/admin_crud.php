<?php
//require '../../private/conn.php';
include '../audit_trail.php';

var_dump($_POST);
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
if(isset($_POST['admin_change_pass'])) {
    if($_POST['password1'] != $_POST['password2']) {
        $_SESSION['error_message'] = 'Password do not match. Try again';
        header('Location: ../../index.php?page=admin_password');
    } else {

        AdminChangePassword($_POST['admin_change_pass'], $_POST['password1']);
        header('Location:../../index.php?page=2fa_setup');

    }
}
//Inserts new admin with a value of users_is_admin with a value of 1;
function AdminAdd($first_name, $preposition, $last_name, $email) {

    $password_user = password_hash("password", PASSWORD_DEFAULT);
    include '../../private/conn.php';

    $sql_admin_select = "SELECT users_id, users_first_name, users_preposition, users_last_name, users_email, users_is_admin, users_creation_date FROM tbl_users WHERE users_email = :email ";
//$sql_admin_select = "SELECT users_id, users_first_name, users_preposition, users_last_name, users_email, users_is_admin, users_creation_date FROM tbl_users WHERE users_is_admin = 1 ";
    $sth_admin_select = $db->prepare($sql_admin_select);
    $sth_admin_select->bindParam(":email", $email);
    $sth_admin_select->execute();

    $row = $sth_admin_select->fetch();

    if($row) {
        //print_r($row);
        session_start();
        $_SESSION['error_message'] = 'Email is already in use. Please enter a different email.';
        header('Location: ../../index.php?page=admin_insert');

    } else {

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
}
//Edits the chosen admin with the use of its users_id.
function AdminEdit($first_name, $preposition, $last_name, $user_id) {

    include '../../private/conn.php';

    $sql_admin_insert = 'UPDATE tbl_users SET users_first_name = :first_name, users_preposition = :preposition, users_last_name = :last_name WHERE users_id = :users_id';
    $sth_admin_insert = $db->prepare($sql_admin_insert);
    $sth_admin_insert->bindParam(":first_name", $first_name);
    $sth_admin_insert->bindParam(":preposition", $preposition);
    $sth_admin_insert->bindParam(":last_name", $last_name);
    $sth_admin_insert->bindParam(":users_id", $user_id);

    $sth_admin_insert->execute();
    header('Location: ../../index.php?page=admin_table');

}
function AdminDelete($admin_id) {
    include '../../private/conn.php';

    $stmt = $db->prepare('UPDATE tbl_users SET users_username = :users_id, users_first_name = :users_id, users_preposition = :users_id, users_last_name = :users_id, users_phonenumber = :users_id, users_city = :users_id, users_date_of_birth = :dob, users_is_admin = 0, users_is_active = 0  WHERE users_id = :users_id');
    $stmt->bindParam(':users_id', $admin_id);
    $stmt->bindParam(':dob', $dob);
    if($stmt->execute()){
        header('Location:../../index.php?page=admin_table');
    } else {
        $_SESSION['notification'] = "Something went wrong";
    }
    /*$sql_admin_delete = 'DELETE FROM tbl_users WHERE users_id = :user_id';
    $sth_admin_delete = $db->prepare($sql_admin_delete);
    $sth_admin_delete->bindParam(":user_id", $admin_id);
    $sth_admin_delete->execute();
    header('Location: ../../index.php?page=admin_table');*/

}
function AdminChangePassword($admin_id, $admin_password) {
    include '../../private/conn.php';
    $pass = password_hash($admin_password, PASSWORD_DEFAULT);

    $sql_admin_password_insert = 'UPDATE tbl_users SET users_password = :password WHERE users_id = :users_id';
    $sth_admin_password_insert = $db->prepare($sql_admin_password_insert);
    $sth_admin_password_insert->bindParam(":users_id", $admin_id);
    $sth_admin_password_insert->bindParam(":password", $pass);

    $sth_admin_password_insert->execute();


}

//Selects the logged-in admin.
/*$sql_admin_select = "SELECT users_id FROM tbl_users WHERE users_is_admin = ". $_SESSION['role'] . " ";
$sth_admin_select = $db->prepare($sql_admin_select);
$sth_admin_select->execute();
$selected_admin = $sth_admin_select->fetchColumn();*/





