<?php
require '../private/conn.php';
include '../functions/errormessage.php';
if (session_id() == '') {
    session_start();
}
if(isset($_SESSION['notification'])) {
    $error = $_SESSION['notification'];
    errormessage($error);
    unset($_SESSION['notification']);
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

    $stmt = $db->prepare('UPDATE tbl_users SET users_username = :users_username, users_first_name = :users_first_name, users_preposition = :users_preposition, users_last_name = :users_last_name, users_phonenumber = :users_phonenumber, users_city = :users_city  WHERE users_id = :users_id');
    $stmt->bindParam(':users_id', $userID);
    $stmt->bindParam(':users_username', $username);
    $stmt->bindParam(':users_first_name', $firstname);
    $stmt->bindParam(':users_preposition', $preposition);
    $stmt->bindParam(':users_last_name', $lastname);
    $stmt->bindParam(':users_phonenumber', $phone);
    $stmt->bindParam(':users_city', $location);
    if($stmt->execute()){
        header('Location:../index.php?page=user_edit');
    } else {
        $_SESSION['notification'] = "Something went wrong";
    }

}
if(isset($_POST['uncheck_languages'])) {
    foreach($_POST['uncheck_languages'] as $languages) {
        removeTagsFromUser($languages, $_SESSION['users_id']);
    }
    header('Location: ../index.php?page=user_edit');
}

if(isset($_POST['chosen_languages'])) {
    foreach($_POST['chosen_languages'] as $languages) {
        addTagsToUser($languages, $_SESSION['users_id']);
    }
    header('Location: ../index.php?page=user_edit');
}
function addTagsToUser($languages_id, $userID) {
    require '../private/conn.php';

    $sql_add_tag = 'INSERT INTO tbl_users_languages (user_languages_languages_id, user_languages_users_id) VALUES (:value, :user_id)';
    $sth_add_tag = $db->prepare($sql_add_tag);
    $sth_add_tag->bindParam(":value", $languages_id);
    $sth_add_tag->bindParam(":user_id", $userID);
    $sth_add_tag->execute();
}

function removeTagsFromUser($languages_id, $userID) {
    require '../private/conn.php';

    $sql_usertags = "DELETE FROM tbl_users_languages WHERE user_languages_users_id = :user_id AND user_languages_languages_id = :languages_id";
    $stmt_usertags = $db->prepare($sql_usertags);
    $stmt_usertags->bindParam(":user_id", $userID);
    $stmt_usertags->bindParam(":languages_id", $languages_id);
    $stmt_usertags->execute();
    $usertags = $stmt_usertags->fetch(PDO::FETCH_ASSOC);
    return $usertags;
}

if (isset($_POST['delete'])){
    $query = "SELECT YEAR(users_date_of_birth) AS user_year FROM tbl_users WHERE users_id=:users_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':users_id', $_SESSION['users_id']);
    $stmt->execute();

    $useractive = 0;
    $useremail = $userID . "@digidate.nl";
    $query1 = "SELECT users_date_of_birth FROM tbl_users WHERE users_id=:users_id";
    $stmt1 = $db->prepare($query1);
    $stmt1->bindParam(':users_id', $_SESSION['users_id']);
    if ($stmt1->execute()){
        if ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
            $user_year = $row['users_date_of_birth'];
        }
        var_dump($user_year);
        $dob = date_create($user_year);
        var_dump($dob);
        $newdate = date_format (date_modify($dob, 'first day of january'), "Y-m-d");
        var_dump($newdate);
        $stmt = $db->prepare('UPDATE tbl_users 
                                SET users_username = :users_username, users_first_name = :users_first_name, users_preposition = :users_preposition, users_last_name = :users_last_name, users_phonenumber = :users_phonenumber, users_email = :users_email, users_password = :users_password, users_description = :users_description, users_is_active = :users_is_active, users_date_of_birth = :users_date_of_birth
                                WHERE users_id = :users_id');
        $stmt->bindParam(':users_id', $userID);
        $stmt->bindParam(':users_username', $userID);
        $stmt->bindParam(':users_first_name', $userID);
        $stmt->bindParam(':users_preposition', $userID);
        $stmt->bindParam(':users_last_name', $userID);
        $stmt->bindParam(':users_phonenumber', $userID);
        $stmt->bindParam(':users_password', $userID);
        $stmt->bindParam(':users_description', $userID);
        $stmt->bindParam(':users_is_active', $useractive);
        $stmt->bindParam(':users_email', $useremail);
        $stmt->bindParam(':users_date_of_birth', $newdate);
        if($stmt->execute()){
            session_destroy();
            header('Location:../index.php?page=login');
        } else {
            $_SESSION['notification'] = "Something went wrong";
        }
    } else {
        $_SESSION['notification'] = "Something went wrong";
    }

}

?>
