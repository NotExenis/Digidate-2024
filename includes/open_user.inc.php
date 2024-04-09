<?php
require 'private/conn.php';
$id = $_POST['user_id'];

$sql = "SELECT * FROM tbl_users WHERE tbl_users.users_id = :user_id";
$stmt = $db->prepare($sql);
$stmt->execute(array(
    'user_id' => $id,
));
$r = $stmt->fetch();

$sql2 = "SELECT * FROM tbl_images WHERE images_user_id = :user_id";
$stmt2 = $db->prepare($sql2);
$stmt2->execute(array(
    'user_id' => $id,
));
$images = $stmt2->fetch();

$sql3 = "SELECT * FROM tbl_education WHERE education_id = :education_id";
$stmt3 = $db->prepare($sql3);
$stmt3->execute(array(
    ':education_id' => $r['users_education_id'],
));
$studies = $stmt3->fetch();

$sql4 = "SELECT T.tags_title, T.tags_color 
         FROM tbl_usertags AS U INNER JOIN tbl_tags AS T 
         ON U.usertags_tags_id = T.tags_id 
         WHERE U.usertags_users_id = :user_id";
$stmt4 = $db->prepare($sql4);
$stmt4->execute(array(
    ':user_id' => $id,
));
?>

<div class="container">
    <div class="row">
        <div class="col-lg-6 mx-auto mt-5">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    User Profile
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <?php if (!empty($images)) { ?>
                            <?php if (count($images) > 1) { ?>
                                <div id="carouselExampleControls<?= $r['users_id'] ?>" class="carousel slide" data-ride="carousel" style="max-width: 200px;">
                                    <div class="carousel-inner">
                                        <?php foreach ($images as $key => $image) { ?>
                                            <div class="carousel-item <?= ($key == 0) ? 'active' : '' ?>">
                                                <img src="data:image/png;base64, <?= $image['images_image'] ?>" alt="User Image" class="card-img-top" style="width: 100%; height: 100%;">
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <a class="carousel-control-prev" href="#carouselExampleControls<?= $r['users_id'] ?>" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only"></span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleControls<?= $r['users_id'] ?>" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only"></span>
                                    </a>
                                </div>
                            <?php } else { ?>
                                <img src="data:image/png;base64, <?= $images[0]['images_image'] ?>" alt="User Image" class="card-img-top" style="width: 100%; height: 100%;">
                            <?php } ?>
                        <?php } else { ?>
                            <?php if ($r['users_gender_id'] == 1) { ?>
                                <img src="./photos/istockphoto-477333976-612x612.jpg" class="card-img-top" alt="Placeholder Image" style="width: 100%; height: 100%;">
                            <?php } else { ?>
                                <img src="./photos/male-profile-picture-vector.jpg" class="card-img-top" alt="Placeholder Image" style="width: 100%; height: 100%;">
                            <?php } ?>
                        <?php } ?>
                        <div class="mt-3">
                            <h5 class="card-title">Username: <?= $r['users_username']; ?></h5>
                            <p class="card-text">Name: <?= $r['users_first_name'] ?></p>
                            <p class="card-text">Date of Birth: <?= $r['users_date_of_birth']; ?></p>
                            <p class="card-text">Education: <?= $studies['education_name']; ?></p>
                            <p class="card-text">Woonplaats: <?= $r['users_city']; ?></p>
                            <p class="card-text">Education: <?= $r['users_description']; ?></p>
                            <p class="card-text" >Tags: </p>
                            <?php foreach ($stmt4 as $r){ ?>
                                <span class="badge rounded-fill badge-clickable" style="background-color: <?= $r['tags_color'] ?>"><?= $r['tags_title'] ?></span>
                            <?php } ?>  
                            <br>
                            <br>
                            <form action="php/like_dislike.php" method="post">
                                <input type="hidden" name="user_id_like" value="<?= $id ?>">
                                <button type="submit" class="btn btn-success">Like</button>
                            </form>
                            <br>
                            <form action="php/like_dislike.php" method="post">
                                <input type="hidden" name="user_id_dislike" value="<?= $id ?>">
                                <button type="submit" class="btn btn-danger">Dislike</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>