<?php
require_once 'vendor/autoload.php';
require 'private/conn.php';
use PragmaRX\Google2FAQRCode\Google2FA;


$sql = 'SELECT * FROM tbl_users WHERE users_id = :users_id';
$stmt = $db->prepare($sql);
$stmt->execute(array(
    ':users_id' => $_SESSION['users_id']
));
$email = $stmt->fetch();


// Initialize Google2FA with Bacon QR Code service
$google2fa = new Google2FA();

// Generate secret key
$secretKey = $google2fa->generateSecretKey();

// Display QR code inline
$inlineUrl = $google2fa->getQRCodeInline(
    'DigiDate',
    $email[0],
    $secretKey
);

//var_dump($inlineUrl);

echo "{$inlineUrl}";
?>
    <form action="index.php?page=2fa_confirm" method="post">
        <input name="2fa_token">
        <input type="hidden" name="secret_key" value="<?= $secretKey ?>">
        <button type="submit">Submit</button>
    </form>
<?php

//form to success/error page for 2fa.
// Verify token
