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
        $("#image").on("change", function() {
            if ($("#image")[0].files.length > 5) {
                alert("You can select only 5 images");
                window.location.href = "http://localhost/digidate/index.php?page=profile_users_edit";
            }
        });
    });
</script>
<div class="container">
    <div class="col-sm">
    </div>
    <div class="col-sm">

<?php
multiFormTags('tbl_tags');
?>

    </div>
    <div class="col-sm">
    </div>

</div>

<div class="container">
    <div class="row">
        <div class="col-sm">

        </div>
        <div class="col-sm">
            <form method="POST" enctype="multipart/form-data" action="php/photo_upload.php">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" name="email" placeholder="Enter email" >
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="password" name="password" >
                </div>
                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <select class="form-select" name="language">
                        <?php foreach ($stmt_location->fetchAll(PDO::FETCH_ASSOC) as $location) { ?>
                            <option value="<?=$location['municipality_id']?>"><?= $location['municipality_name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <?php //fix dit nog aub ?>
                <div class="mb-3">
                    <label for="education" class="form-label">Education</label>
                    <select class="form-select" name="education" >
                        <?php foreach($stmt_education as $education){

                            if($education['education_name'] == $stmt_user_education->fetch()) {
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
                    <label for="education" class="form-label">Tags</label>
                    <select class="form-select" value="<?= $tags['tags_id']?>" name="tag[]" multiple>
                        <?php foreach($stmt_tags as $tags){ ?>
                            <option><?= $tags['tags_title'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group mb-3 mt-3">
                    <label>Select Image File:</label>
                    Upload this file: <input type=file name="image[]" id="image" multiple="multiple" accept="image/jpeg, image/jpg, image/png">
                </div>
                <?php foreach ($stmt_images->fetchAll(PDO::FETCH_ASSOC) as $image) { ?>
                    <img src="data:image/jpeg;base64, <?= $image['images_image'] ?> " style="max-width: 200px" />
                <?php
                }
                 ?>

                <br>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
        <div class="col-sm">
        </div>
    </div>
</div>