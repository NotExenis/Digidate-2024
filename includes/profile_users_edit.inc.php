<?php
require 'private/conn.php';
require 'functions/multi_select_form.php';
if (isset($_SESSION['notification'])) {
    echo '<p class="text-red-500">' . $_SESSION['notification'] . '</p>';
    unset($_SESSION['notification']);
}

$sql_user_info = "SELECT * FROM tbl_users WHERE users_id = :user_id";
$stmt_user_info = $db->prepare($sql_user_info);
$stmt_user_info->bindParam(":user_id", $_SESSION['users_id']);
$stmt_user_info->execute();
$user_info = $stmt_user_info->fetch(PDO::FETCH_ASSOC);

$sql_education = "SELECT education_name 
                 FROM tbl_education";
$stmt_education = $db->prepare($sql_education);
$stmt_education->execute();

$sql_tags = "SELECT tags_title, tags_id, tags_color
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

    document.addEventListener('DOMContentLoaded', function() {
        // Get the button element
        var openModalButton = document.getElementById('openModalButton');

        // Add a click event listener to the button
        openModalButton.addEventListener('click', function() {
            // Use jQuery to trigger the modal display
            $('#tags_modal').modal('show');
        });

        // Get the close buttons within the modal
        var modalCloseButtons = document.querySelectorAll('#tags_modal .btn-close, #tags_modal [data-bs-dismiss="modal"]');

        // Add click event listeners to each close button
        modalCloseButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                // Use jQuery to close the modal
                $('#tags_modal').modal('hide');
            });
        });
    });

    $(document).ready(function() {
        $("#image").on("change", function() {
            if ($("#image")[0].files.length > 5) {
                alert("You can select only 5 images");
                window.location.href = "http://localhost/digidate/index.php?page=profile_users_edit";
            }
        });
    });
    $(document).ready(function() {
        // Click event handler for clickable badges
        $('.badge-clickable').click(function() {
            // Get the associated checkbox
            var checkbox = $(this).prev('input[type="checkbox"]');

            // Toggle the checkbox's checked state
            checkbox.prop('checked', !checkbox.prop('checked'));
        });
    });
</script>

<!-- Modal -->
<div class="modal fade" id="tags_modal" tabindex="-1" aria-labelledby="tags_modal_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Tags</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="php/CRUD/user_crud.php" method="post">
                    <label for="Tags" class="form-label">Chosen Tags</label>
                    <div class="container">
                        <?php foreach($usertags as $tags){
                            $color = isset($tags["tags_color"]) ? $tags["tags_color"] : "blue";
                            ?>
                            <!-- Add hidden checkbox -->
                            <input type="checkbox" name="uncheck_tags[]" value="<?= $tags['tags_id'] ?>" style="display: none;">
                            <span class="badge rounded-fill badge-clickable" style="background-color: <?= $color ?>" data-tag-id="<?= $tags['tags_id'] ?>">
                <?= $tags['tags_title'] ?>
            </span>
                        <?php } ?>
                    </div>
                    <hr class="rounded">
                    <div class="container">
                        <?php foreach($stmt_tags->fetchAll(PDO::FETCH_ASSOC) as $tags){
                            $color = isset($tags["tags_color"]) ? $tags["tags_color"] : "blue";
                            $tagId = $tags['tags_id'];
                            $tagChosen = false; // Initialize as false

                            // Check if the current tag ID exists in the user's chosen tags
                            foreach ($usertags as $usertag) {
                                if ($usertag['tags_id'] == $tagId) {
                                    $tagChosen = true;
                                    break; // If found, no need to continue searching
                                }
                            }
                            if(!$tagChosen) {
                                ?>
                                <!-- Add hidden checkbox -->
                                <input type="checkbox" name="chosen_tags[]" value="<?= $tagId ?>" style="display: none;">
                                <span class="badge rounded-fill badge-clickable" style="background-color: <?= $color ?>" data-tag-id="<?= $tagId ?>">
                    <?= $tags['tags_title'] ?>
                </span>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm">
        </div>
        <div class="col-sm">

            <h5>Edit Profile</h5>
            <h5><?= $user_info['users_username'] ?></h5>

            <form method="POST" enctype="multipart/form-data" action="php/photo_upload.php">
                <?php //fix dit nog aub ?>
                <div class="mb-3">
                    <label for="education" class="form-label">Education</label>
                    <select class="form-select" name="education" >
                        <?php foreach ($stmt_education->fetchAll(PDO::FETCH_ASSOC) as $education) {

                            if($stmt_user_education->fetch() == $education['education_name']) {
                                ?>
                                <option disabled><?= $education['education_name']?></option>
                                <?php
                            } else {
                                ?>
                                <option><?= $education['education_name']?></option>
                                <?php
                            }
                            ?>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="Tags" class="form-label">Tags</label>
                    <div class="container">
                        <?php foreach($usertags as $tags){
                            $color = isset($tags["tags_color"]) ? $tags["tags_color"] : "blue";
                            ?>
                            <span class="badge rounded-fill badge-clickable" style="background-color: <?= $color ?>"><?= $tags['tags_title'] ?>
                        </span>
                        <?php }
                        ?>

                        <button type="button" class="btn btn-primary" id="openModalButton">
                            Edit Tags
                        </button>
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
                            if($x == 0) {
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