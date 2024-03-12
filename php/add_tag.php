<?php
require '../private/conn.php';

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
} else {
    $_SESSION['notification'] = "Tag you have chosen already exists.";
    header('Location:../index.php?page=add_tag');
}


?>

JP WAS HERE.