<?php
session_start();
require '../private/conn.php';


if ($_FILES) {
    foreach ($_FILES['image']['tmp_name'] as $key => $tmp_name) {
        $pic = ($_FILES['image']['tmp_name'][$key]) ? base64_encode(file_get_contents($_FILES['image']['tmp_name'][$key])) : null;

        $sql_insert_photo = "INSERT INTO tbl_images (images_user_id, images_image) VALUES (:user_id, :image)";
        $stmt_insert_photo = $db->prepare($sql_insert_photo);
        $stmt_insert_photo->bindParam(":user_id", $_SESSION['users_id']);
        $stmt_insert_photo->bindParam(":image", $pic);
        $stmt_insert_photo->execute();

        ?>
        <img src="data:image/jpeg;base64, <?= $pic ?> " style="max-width: 200px" />
        <?php

    }

}


