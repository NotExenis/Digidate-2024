<?php
session_start();
require '../private/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $infix = $_POST['infix'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $genders = $_POST['gender'];
    $city = $_POST['location'];
    $pic = ($_FILES['photo']['tmp_name'] ?? null) ? base64_encode(file_get_contents($_FILES['photo']['tmp_name'])) : null;
    $birthday = date('Y-m-d', strtotime($_POST['age']));
    $phone = $_POST['phone'];
    $role = '0';
    $first_time = 1;

    $required_fields = ['username', 'firstname', 'lastname', 'phone', 'email', 'password', 'location', 'gender', 'age'];
    foreach ($required_fields as $fields) {
        if (empty($_POST[$fields])) {
            $_SESSION['notification'] = 'Please fill in all the required fields';
            header('location:../index.php?page=register');
            exit;
        }
    }

    function is_valid_password($password)
    {
        return preg_match('/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*()-_=+{};:,<.>]).{15,}$/', $password);
    }

    if (!is_valid_password($_POST['password'])) {
        $_SESSION['notification'] = 'Password is invalid, make sure it contains exactly 15 characters, at least 1 uppercase letter, 1 lowercase letter, 1 special character, and 1 number';
        header('location:../index.php?page=register');
        exit;
    }


    $sql = 'SELECT * FROM tbl_users WHERE users_email =:email';
    $stmt = $db->prepare($sql);
    $stmt->execute(array(
        ':email' => $email,
    ));

    if ($stmt->rowcount() == 0) {
        if ($pic == null) {
            $sql2 = "INSERT INTO tbl_users(users_username,users_first_name,users_preposition, users_last_name, users_email, users_password,
                    users_gender_id,users_city, users_date_of_birth, users_phonenumber, users_is_admin, users_first_login)
                    VALUES(:username, :firstname,:users_preposition, :lastname, :email, :password, :gender, :city, :dob,  :phone, :isadmin, :firsttime)";
            $stmt2 = $db->prepare($sql2);
            $stmt2->execute(array(
                ':username' => $username,
                ':firstname' => $name,
                ':lastname' => $last_name,
                ':email' => $email,
                ':password' => $password,
                ':gender' => $genders,
                ':city' => $city,
                ':dob' => $birthday,
                ':phone' => $phone,
                ':isadmin' => $role,
                ':firsttime' => $first_time,
                ':users_preposition' => $infix
            ));
            header('location:../index.php?page=login');
        } else {
            $sql2 = "INSERT INTO tbl_users(users_username,users_preposition,users_first_name, users_last_name, users_email, users_password,
                    users_gender_id,users_city, users_date_of_birth, users_phonenumber, users_is_admin, users_first_login)
                    VALUES(:username, :firstname, :users_preposition, :lastname, :email, :password, :gender, :city, :dob,  :phone, :isadmin, :firsttime)";
            $stmt2 = $db->prepare($sql2);
            $stmt2->execute(array(
                ':username' => $username,
                ':firstname' => $name,
                ':lastname' => $last_name,
                ':email' => $email,
                ':password' => $password,
                ':gender' => $genders,
                ':city' => $city,
                ':dob' => $birthday,
                ':phone' => $phone,
                ':isadmin' => $role,
                ':firsttime' => $first_time,
                ':users_preposition' => $infix
            ));
            $user_id = $db->lastInsertId();
            $sql3 = "INSERT INTO tbl_images (images_user_id, images_image)
                     VALUES (:user_id, :photo)";
            $stmt3 = $db->prepare($sql3);
            $stmt3->execute(array(
                ':user_id' => $user_id,
                ':photo' => $pic,
            ));
            header('location:../index.php?page=login');
        }
    } else {
        $_SESSION['notification'] = "Your Email is already in use";
        header('location:../index.php?page=register');
    }
} else {
    $_SESSION['notification'] = "Something went wrong. Please try again";
}
