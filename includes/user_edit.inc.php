<?php
require 'private/conn.php';
if (session_id() == '') {
    session_start();
}


$sql_languages = "SELECT *
                 FROM tbl_languages";
$stmt_languages = $db->prepare($sql_languages);
$stmt_languages->execute();

$sql_location = "SELECT *
                 FROM tbl_municipalities";
$stmt_location = $db->prepare($sql_location);
$stmt_location->execute();


$query = "SELECT * FROM tbl_users WHERE users_id=:users_id";
$stmt = $db->prepare($query);
$stmt->bindParam(':users_id', $_SESSION['users_id']);
$stmt->execute();
if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $username = $row['users_username'];
    $firstname = $row['users_first_name'];
    $preposition = $row['users_preposition'];
    $lastname = $row['users_last_name'];
    $phonenumber = $row['users_phonenumber'];
    $location_id = $row['users_city'];

}

$sql_currentlocation = "SELECT *
                 FROM tbl_municipalities WHERE municipality_id = :municipality_id";
$stmt_currentlocation = $db->prepare($sql_currentlocation);
$stmt_currentlocation->bindParam(':municipality_id', $location_id);
$stmt_currentlocation->execute();
if ($row = $stmt_currentlocation->fetch(PDO::FETCH_ASSOC)) {
    $currentlocation = $row['municipality_name'];
}
$sql_currentlanguages = "SELECT *
                 FROM tbl_users_languages INNER JOIN tbl_languages ON tbl_users_languages.user_languages_languages_id = tbl_languages.languages_id WHERE user_languages_users_id = :user_languages_users_id";
$stmt_currentlanguages = $db->prepare($sql_currentlanguages);
$stmt_currentlanguages->bindParam(':user_languages_users_id', $_SESSION['users_id']);
$stmt_currentlanguages->execute();
if ($row = $stmt_currentlanguages->fetch(PDO::FETCH_ASSOC)) {

}


?>
<script src="./functions/showpass.js"></script>
<div class="container">
    <div class="row">
        <div class="col-sm">
            <button type="button" id="delete" class="btn btn-danger">Delete</button>
        </div>
        <div class="col-sm">
            <div class="registration">
                <h1>Edit Account</h1>
                <form action="php/user_edit.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username *</label>
                        <input type="text" class="form-control" name="username" value="<?php echo $username; ?>"
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="firstname" class="form-label">First name *</label>
                        <input type="text" class="form-control" id="firstname" name="firstname"
                               value="<?php echo $firstname; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="preposition" class="form-label">Preposition</label>
                        <input type="text" class="form-control" name="preposition" value="<?php echo $preposition; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="lastname" class="form-label">Last name *</label>
                        <input type="text" class="form-control" id="lastname" name="lastname"
                               value="<?php echo $lastname; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Phone number *</label>
                        <input type="number" class="form-control" name="phone" value="<?php echo $phonenumber; ?>"
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label">Location *</label>
                        <select class="form-select" name="location" required>
                            <?php
                            if ($location_id > 0) {
                                ?>
                                <option selected disabled value="$location_id"><?= $currentlocation ?></option>
                                <?php foreach ($stmt_location->fetchAll(PDO::FETCH_ASSOC) as $location) { ?>
                                    <option value="<?=$location['municipality_id']?>"><?= $location['municipality_name'] ?></option>
                                <?php }
                            } else{
                            ?>
                            <?php foreach ($stmt_location->fetchAll(PDO::FETCH_ASSOC) as $location) { ?>
                                <option value="<?=$location['municipality_id']?>"><?= $location['municipality_name'] ?></option>
                                <?php
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label">Language</label>
                        <select class="form-select" name="language[]" size="6" id="language" multiple>
                            <?php foreach ($stmt_languages->fetchAll(PDO::FETCH_ASSOC) as $language) { ?>
                                <option value="<?= $language['languages_id'] ?>"><?= $language['languages_name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" id="edit">Edit</button>
                </form>
            </div>
        </div>
        <div class="col-sm">
        </div>
    </div>
</div>