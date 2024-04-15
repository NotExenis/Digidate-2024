<?php
require '../private/conn.php' ;
require 'vendor/autoload.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$uid = uniqid (rand (), true);
$dt_now = new DateTime('now');
$dt_now2 = new DateTime('now');
$dt = date_modify($dt_now, '+1 hour');
print_r($dt_now);
$diff = $dt->diff($dt_now2, true);
print_r($diff);

$id = $_POST['id'];

$sql = "UPDATE tbl_users
        SET archive = 1
        WHERE user_id = :id";
$stmt = $conn->prepare($sql);
$stmt->execute(array(
    ':id' => $id,
));

$sql2 = "SELECT user_email FROM tbl_users WHERE user_id = :id";
$stmt2 = $conn->prepare($sql2);
$stmt2->execute(array(
    ':id' => $id,
));

$r = $stmt2->fetchAll();

$to = $r[0]['user_email'];

$mail = new PHPMailer(true);

// sending the user a email if denied
try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP(true);
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'digidate2023@gmail.com';
    $mail->Password   = 'ociu hhkm zaqm fvch';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;
    $mail->isHTML(true);

    //Recipients
    $mail->setFrom('digidate@gmail.com', 'Digidate');
    $mail->addAddress( $to );
    $mail->addReplyTo('digidate@gmail.com', 'Information');
    $mail->addCC('digidate2023@gmail.com');

    //Content
    $mail->isHTML(true);
    $mail->Subject = 'Digidate';
    $mail->Body    = 'Your request to join Digidate has been denied';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

header('location: ../index.php?page=login');
?>