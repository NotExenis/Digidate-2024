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

if(isset($_POST['user_id_pass'])) {
    $user_id = $_POST['user_id_pass'];
    $email_message = "
<html lang='en'>
<body>
<b>Your request for password change has been approved</b>. Please click the link <a href='http://localhost/digidate/index.php?page=change_password&user_id=$user_id'> Change Password</a>
</body>
</html>
";
}

if(isset($_POST['user_id_email'])) {
    $user_id = $_POST['user_id_email'];
    $email_message = "
<html lang='en'>
<body>
<b>Your request for email change has been approved</b>. Please click the link <a href='http://localhost/digidate/index.php?page=change_email&user_id=$user_id'> Change Password</a>
</body>
</html>
";
}


$sql2 = "SELECT users_email FROM tbl_users WHERE users_id = :id";
$stmt2 = $db->prepare($sql2);
$stmt2->execute(array(
    ':id' => $user_id,
));
//$id = $_POST['user_id'];
$r = $stmt2->fetch();
$to = $r['users_email'];

$link = '<a href="http://localhost/digidate/index.php?page=change_password&user_id=""> Change Password</a>';
$mail = new PHPMailer(true);
$message = $email_message;
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
$_SESSION['success_message'] = 'Password has been succesfully changed. Please login to continue using the website!';
header('location: ../index.php?page=login');

?>