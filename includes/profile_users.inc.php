<?php
require './private/conn.php';

$page = $_GET['offset'] ?? 1;
$limit = 8;
$start = ($page - 1) * $limit;

$sql = "SELECT COUNT(*) AS total FROM tbl_users";
$stmt = $db->prepare($sql);
$stmt->execute();
$total_rows = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

$total_pages = ceil($total_rows / $limit);

$sql = "SELECT u.*
FROM tbl_users u
WHERE u.users_id != :user_id
AND NOT EXISTS (
    SELECT 1
    FROM tbl_dislikes d
    WHERE (u.users_id = d.dislikes_disliked_user AND d.dislikes_current_user = :user_id)
    OR (u.users_id = d.dislikes_current_user AND d.dislikes_disliked_user = :user_id)
) 
AND NOT EXISTS (
    SELECT 1
    FROM tbl_unmatch um
    WHERE (u.users_id = um.unmatch_user_id_target AND um.unmatch_user_id_unmatcher = :user_id)
    OR (u.users_id = um.unmatch_user_id_unmatcher AND um.unmatch_user_id_target = :user_id)
) LIMIT $start, $limit";
$stmt = $db->prepare($sql);
$stmt->bindParam(':user_id', $_SESSION['users_id']);
$stmt->execute();

$sql3 = "SELECT * FROM tbl_genders";
$stmt3 = $db->prepare($sql3);
$stmt3->execute();

$sql4 = "SELECT * FROM tbl_education";
$stmt4 = $db->prepare($sql4);
$stmt4->execute();
?>


<div class="container">
    <div class="row row-cols-1 row-cols-md-4 g-4">
        <?php foreach ($stmt as $r) { ?>
            <?php
            $sql3 = "SELECT * FROM tbl_images WHERE images_user_id = :user_id";
            $stmt2 = $db->prepare($sql3);
            $stmt2->execute(array(
                ':user_id' => $r['users_id'],
            ));
            $images = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <div class="col">
                <div class="container mt-5" style="width: 250px;">
                    <div class="card mb-4">
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
                        <div class="card-body">
                            <h5 class="card-title" style="font-size: 16px; margin-bottom: 5px;"><?= $r['users_username'] ?></h5>
                            <p class="card-text" style="font-size: 14px; margin-bottom: 5px;"><?= $r['users_description'] ?></p>
                            <form action="index.php?page=open_user" method="post">
                                <button class="btn btn-info">Open profile</button>
                                <input type="hidden" name="user_id" value="<?= $r['users_id'] ?>">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php if ($page > 1) : ?>
                <li class="page-item">
                    <a class="page-link" href="index.php?page=profile_users&offset=<?php echo $page - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <li class="page-item <?php if ($page == $i) echo 'active'; ?>">
                    <a class="page-link" href="index.php?page=profile_users&offset=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php } ?>
            <?php if ($page < $total_pages) : ?>
                <li class="page-item">
                    <a class="page-link" href="index.php?page=profile_users&offset=<?php echo $page + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>