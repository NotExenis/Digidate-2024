<?php
require '../private/conn.php' ;
require '../vendor/autoload.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
var_dump($_POST);
/*$uid = uniqid (rand (), true);
$dt_now = new DateTime('now');
$dt_now2 = new DateTime('now');
$dt = date_modify($dt_now, '+1 hour');
//print_r($dt_now);
$diff = $dt->diff($dt_now2, true);
//print_r($diff);*/

//$id = $_POST['user_id'];

$sql2 = "SELECT users_email FROM tbl_users WHERE users_id = :id";
$stmt2 = $db->prepare($sql2);
$stmt2->execute(array(
    ':id' => $_POST['user_id'],
));
$id = $_POST['user_id'];
$r = $stmt2->fetch();
$to = $r['users_email'];
var_dump($id);
var_dump($r);
$link = '<a href="http://localhost/digidate/index.php?page=change_password&user_id=""> Change Password</a>';
$mail = new PHPMailer(true);
$message = "
<html lang='en'>
<body>
<b>Your request for password change has been approved</b>. Please click the link <a href='http://localhost/digidate/index.php?page=change_password&user_id=$id'> Change Password</a>
</body>
</html>
";
// sending the user a email if denied
try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP(true);
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'digidate2023@gmail.com';
    $mail->Password   = 'ociu hhkm zaqm fvch';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;
    $mail->isHTML(true);

    //Recipients
    $mail->setFrom('digidate@gmail.com', 'Digidate');
    $mail->addAddress( $to );
    $mail->addReplyTo('digidate@gmail.com', 'Information');
    $mail->addCC('digidate2023@gmail.com');

    //Content
    $mail->isHTML(true);
    $mail->Subject = 'Digidate';
    $mail->Body    =  $message;

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

//header('location: ../index.php?page=login');
?>