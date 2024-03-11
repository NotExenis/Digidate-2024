<?php
require '../private/conn.php';
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$sql = 'SELECT * FROM tbl_users WHERE users_email = :email';
$stmt = $db->prepare($sql);
$stmt->execute(array( 
    ':email'=>$email
));

$r = $stmt->fetch();

if($stmt->rowCount() == 1){
    if(password_verify($password, $r['users_password'])){
        $_SESSION['users_role'] = $r['users_is_admin'];
        $_SESSION['users_id'] = $r['users_id'];
        $_SESSION['first_login'] = $r['users_first_login'];
        $_SESSION['user_active'] = $r['users_is_active'];
        if(isset($_SESSION['users_role'])){
            if($_SESSION['users_role'] == 1 || $_SESSION['users_role'] == 0){
                if($_SESSION['user_active'] == 1){
                    if($_SESSION['first_login'] == 1){
                        header('Location:../index.php?page=2fa_setup');
                        $sql2 = 'UPDATE tbl_users
                                 SET users_first_login = 0
                                 WHERE users_email = :email';
                                 $stmt2 = $db->prepare($sql2);
                                 $stmt2->execute(array(
                                    ':email'=>$email,
                                 ));
                    } else {
                        header('Location:../index.php?page=landing_page');
                    }
                } else {
                    $_SESSION['notification'] = 'Your account seems to have been deleted';
                    header('Location:../index.php?page=login');
                    unset($_SESSION['users_role']);
                    unset($_SESSION['users_id']);
                    unset($_SESSION['first_login']);
                    unset($_SESSION['user_active']);
                }
            } else {
                $_SESSION['notification'] = 'Something went wrong getting your User-ID';
                header('Location:../index.php?page=login');
                unset($_SESSION['users_role']);
                unset($_SESSION['users_id']);
                unset($_SESSION['first_login']);
                unset($_SESSION['user_active']);
            }
        } else {
            $_SESSION['notification'] = 'Something went wrong setting your role';
            header('Location:../index.php?page=login');
            unset($_SESSION['users_role']);
            unset($_SESSION['users_id']);
            unset($_SESSION['first_login']);
            unset($_SESSION['user_active']);
        }
    } else {
        $_SESSION['notification'] = 'Your password does not match';
        header('Location:../index.php?page=login');
        unset($_SESSION['users_role']);
        unset($_SESSION['users_id']);
        unset($_SESSION['first_login']);
        unset($_SESSION['user_active']);
    }
} else {
    $_SESSION['notification'] = 'Your Email has not been found';
    header('Location:../index.php?page=login');
}

?>