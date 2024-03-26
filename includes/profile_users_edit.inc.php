<?php
require 'private/conn.php';
require 'functions/multi_select_form.php';
if (isset($_SESSION['notification'])) {
    echo '<p class="text-red-500">' . $_SESSION['notification'] . '</p>';
    unset($_SESSION['notification']);
}
$sql_location = "SELECT municipality_name, municipality_id
                 FROM tbl_municipalities";
$stmt_location = $db->prepare($sql_location);
$stmt_location->execute();

$sql_education = "SELECT education_name 
                 FROM tbl_education";
$stmt_education = $db->prepare($sql_education);
$stmt_education->execute();

$sql_tags = "SELECT tags_title, tags_id 
                 FROM tbl_tags";
$stmt_tags = $db->prepare($sql_tags);
$stmt_tags->execute();

$sql_usertags = "SELECT * FROM tbl_usertags INNER JOIN tbl_tags ON tags_id = usertags_tags_id WHERE usertags_users_id = :user_id";
$stmt_usertags = $db->prepare($sql_usertags);
$stmt_usertags->bindParam(":user_id", $_SESSION['users_id']);
$stmt_usertags->execute();
$usertags = $stmt_usertags->fetchAll(PDO::FETCH_ASSOC);

$sql_images = "SELECT * FROM tbl_images WHERE images_user_id = :user_id";
$stmt_images = $db->prepare($sql_images);
$stmt_images->bindParam(":user_id", $_SESSION['users_id']);
$stmt_images->execute();

$sql_user_education = "SELECT education_name FROM tbl_users INNER JOIN tbl_users_education ON users_education_users_id = users_id INNER JOIN tbl_education ON education_id = users_education_id WHERE users_id = :user_id";
$stmt_user_education = $db->prepare($sql_user_education);
$stmt_user_education->bindParam(":user_id", $_SESSION['users_id']);
$stmt_user_education->execute();
?>
<script>
    $(document).ready(function() {
        $("#tag_modal").hide();
        $("#image").on("change", function() {
            if ($("#image")[0].files.length > 5) {
                alert("You can select only 5 images");
                window.location.href = "http://localhost/digidate/index.php?page=profile_users_edit";
            }
        });
    });
    $("#add_tag").on("click", function() {
        $("#tag_modal").show(); // Show the tag_modal div when add_tag button is clicked
    });
    $('#close').on('click', function() {
        $('#error').hide();
    });

    const element = document.getElementById("add_tag");
    element.addEventListener("click", myFunction);

    function myFunction() {
        document.getElementById("tag_modal").innerHTML = "multiFormTags()";
    }
</script>

<?php
?>
<div id="tag_modal"></div>

<div class="container">
    <div class="row">
        <div class="col-sm">

        </div>
        <div class="col-sm">
            <form method="POST" enctype="multipart/form-data" action="php/photo_upload.php">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" name="email" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <select class="form-select" name="language">
                        <?php foreach ($stmt_location->fetchAll(PDO::FETCH_ASSOC) as $location) { ?>
                            <option value="<?= $location['municipality_id'] ?>"><?= $location['municipality_name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="education" class="form-label">Education</label>
                    <select class="form-select" name="education">
                        <?php foreach ($stmt_education as $education) {

                            if ($education['education_name'] == $stmt_user_education->fetch()) {
                        ?>
                                <option disabled><?= $education['education_name'] ?></option>

                            <?php
                            } else {
                            ?>
                                <option><?= $education['education_name'] ?></option>

                            <?php
                            }
                            ?>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="education" class="form-label">Tags</label>
                    <div class="container">
                        <?php foreach ($usertags as $tags) {
                            $color = isset($tags["tags_color"]) ? $tags["tags_color"] : "blue";
                        ?>
                            <span class="badge rounded-fill badge-clickable" style="background-color: <?= $color ?>"><?= $tags['tags_title'] ?>
                            </span>
                        <?php }
                        ?>
                        <badge id="add_tag" class="bi bi-plus bg-primary p-2 badge-clickable" onclick="">Add tag</badge>
                    </div>
                    </select>
                </div>
                <div class="form-group mb-3 mt-3">
                    Upload this file: <input type=file name="image[]" id="image" multiple="multiple" accept="image/jpeg, image/jpg, image/png">
                </div>
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" style="max-width: 300px">
                    <div class="carousel-inner p-5">
                        <?php
                        $x = 0;
                        foreach ($stmt_images->fetchAll(PDO::FETCH_ASSOC) as $image) {

                            if ($x == 0) {
                        ?>
                                <div class="carousel-item active">
                                    <img class="d-block w-200" src="data:image/jpeg;base64, <?= $image['images_image'] ?> " style="max-width: 200px" />
                                </div>
                            <?php
                            } else {
                            ?>
                                <div class="carousel-item">
                                    <img class="d-block w-200" src="data:image/jpeg;base64, <?= $image['images_image'] ?> " style="max-width: 200px" />
                                </div>
                        <?php
                            }
                            $x++;
                        }
                        ?>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only"></span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only"></span>
                    </a>
                </div>


                <br>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
        <div class="col-sm">
        </div>
    </div>
</div>