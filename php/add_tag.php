<?php
session_start();
require '../private/conn.php';
include '../php/audit_trail.php';

$tag = $_POST['tag'];
$color = $_POST['colorpick'];

$sql = "SELECT * FROM tbl_tags WHERE tags_title = :tag";
$stmt = $db->prepare($sql);
$stmt->execute(array( 
    ':tag' => $tag,
));

if($stmt->rowCount() == 0){
    $sql2 = "INSERT INTO tbl_tags (tags_title, tags_color) 
             VALUES (:tag, :color)";
    $stmt2 = $db->prepare($sql2);
    $stmt2->execute(array(
        ':tag' => $tag,
        ':color' => $color
    ));

    Audit_TagCreate($_SESSION['users_id'], $tag);
    header('Location:../index.php?page=tags');
} else {
    $_SESSION['notification'] = "Tag you have chosen already exists.";
    header('Location:../index.php?page=add_tag');
}


?>

