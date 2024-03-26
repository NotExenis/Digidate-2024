<?php
require '../private/conn.php';
if (session_id() == '') {
    session_start();
}
$userID = $_SESSION['users_id'];
if(isset($_POST['EditUser'])){

    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $preposition = $_POST['preposition'];
    $lastname = $_POST['lastname'];
    $phone = $_POST['phone'];
    $location = $_POST['location'];
    $language = $_POST['language'];

    $stmt = $db->prepare('UPDATE tbl_users SET users_username = :users_username, users_first_name = :users_first_name, users_preposition = :users_preposition, users_last_name = :users_last_name, users_phonenumber = :users_phonenumber, users_city = :users_city  WHERE user_id = :user_id');
    $stmt->bindParam(':user_id', $userID);
    $stmt->bindParam(':users_username', $username);
    $stmt->bindParam(':users_first_name', $firstname);
    $stmt->bindParam(':users_preposition', $preposition);
    $stmt->bindParam(':users_last_name', $lastname);
    $stmt->bindParam(':users_phonenumber', $phone);
    $stmt->bindParam(':users_city', $location);
    if($stmt->execute()){

    }

}

?>
