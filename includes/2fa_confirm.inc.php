<?php

// Initialize Google2FA with Bacon QR Code service
require_once 'vendor/autoload.php';
require 'private/conn.php';
use PragmaRX\Google2FAQRCode\Google2FA;

$google2fa = new Google2FA();


if(isset($_POST['2fa_token'])) {
    $valid = $google2fa->verifyKey($_POST['secret_key'], $_POST['2fa_token']);
    if ($valid) {
        echo "Token is valid!";
        $sql2 = 'UPDATE tbl_users
                             SET users_first_login = 0
                             WHERE users_id = :user_id';
        $stmt2 = $db->prepare($sql2);
        $stmt2->execute(array(
            ':user_id' => $_SESSION['users_id'],
        ));
        header('Location:../index.php?page=landing_page');
    } else {
        echo "Token is invalid!";
        $_SESSION['notification'] = 'Two-Factor Authentication error. Please try again.';
        header('Location:index.php?page=login');

    }
}
