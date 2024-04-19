<?php
require '../private/conn.php';
require '../functions/unset_function.php';
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$sql = 'SELECT * FROM tbl_users WHERE users_email = :email';
$stmt = $db->prepare($sql);
$stmt->execute(array(
    ':email' => $email
));

$r = $stmt->fetch();

if (password_verify($password, $r['users_password'])) {
    $_SESSION['users_role'] = $r['users_is_admin'];
    $_SESSION['users_id'] = $r['users_id'];
    $_SESSION['first_login'] = $r['users_first_login'];
    $_SESSION['user_active'] = $r['users_is_active'];
    if (isset($_SESSION['users_role'])) {
        if ($_SESSION['users_role'] == 1 || $_SESSION['users_role'] == 0) {
            if ($_SESSION['user_active'] == 1) {
                if ($_SESSION['first_login'] == 1) {
                    if($_SESSION['users_role'] == 1) {
                        header('Location:../index.php?page=admin_password');
                    } else {
                        header('Location:../index.php?page=2fa_setup');
                    }
                } else {
                    header('Location:../index.php?page=landing_page');
                }
            } else {
                $_SESSION['notification'] = 'Your account seems to have been deleted';
                header('Location:../index.php?page=login');
                unsetSessions();
            }
        } else {
            $_SESSION['notification'] = 'Something went wrong getting your User-ID';
            header('Location:../index.php?page=login');
            unsetSessions();
        }
    } else {
        $_SESSION['notification'] = 'Something went wrong getting your role';
        header('Location:../index.php?page=login');
        unsetSessions();
    }
} else {
    $_SESSION['notification'] = 'Your password does not match';
    header('Location:../index.php?page=login');
    unsetSessions();
}
