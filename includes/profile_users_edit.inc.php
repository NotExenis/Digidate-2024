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


?>
<div class="container">
    <div class="col-sm">
    </div>
    <div class="col-sm">

<?php
multiForm('tbl_tags');
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
            <form method="POST" action="">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" name="email" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <select class="form-select" name="language">
                        <?php foreach ($stmt_location->fetchAll(PDO::FETCH_ASSOC) as $location) { ?>
                            <option value="<?=$location['municipality_id']?>"><?= $location['municipality_name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="education" class="form-label">Education</label>
                    <select class="form-select"  value="<?= $education['education_id']?>" name="education" >
                        <?php foreach($stmt_education as $education){ ?>
                            <option><?= $education['education_name']?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="education" class="form-label">Tags</label>
                    <select class="form-select" value="<?= $tags['tags_id']?>" name="tag[]" multiple>
                        <?php foreach($stmt_tags as $tags){ ?>
                            <option><?= $tags['tags_title']?></option>
                        <?php } ?>
                    </select>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
        <div class="col-sm">
        </div>
    </div>
</div>