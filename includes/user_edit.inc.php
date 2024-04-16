<?php
require 'private/conn.php';
include 'functions/errormessage.php';
include 'functions/popupmessage.php';
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
$result = $stmt_currentlanguages->fetchAll(PDO::FETCH_ASSOC);

?>
<script src="./functions/showpass.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the button element
        var openModalButton = document.getElementById('openModalButton');
        // Add a click event listener to the button
        openModalButton.addEventListener('click', function() {
            // Use jQuery to trigger the modal display
            $('#language_modal').modal('show');
        });
        // Get the close buttons within the modal
        var modalCloseButtons = document.querySelectorAll('#language_modal .btn-close, #language_modal [data-bs-dismiss="modal"]');
        // Add click event listeners to each close button
        modalCloseButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                // Use jQuery to close the modal
                $('#language_modal').modal('hide');
            });
        });
    });
</script>
<div class="modal fade" id="language_modal" tabindex="-1" aria-labelledby="tags_modal_label" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel" >Add Tags</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="php/user_edit.php" method="post">
                <label for="Languages" class="form-label">Chosen Tags</label>
                <div class="container">
                    <?php foreach($result as $currentlanguages){
                        $color = "#" . str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);
                        ?>
                        <!-- Add hidden checkbox -->
                        <input type="checkbox" name="uncheck_languages[]" value="<?= $currentlanguages['user_languages_languages_id'] ?>" style="display: none;">
                        <span class="badge rounded-fill badge-clickable" style="background-color: <?= $color ?>" data-language-id="<?= $currentlanguages['user_languages_languages_id'] ?>">
                <?= $currentlanguages['languages_name'] ?>
            </span>
                    <?php } ?>
                </div>
                <hr class="rounded">
                <div class="container">
                    <?php foreach($stmt_languages->fetchAll(PDO::FETCH_ASSOC) as $languages){
                        $color = "#" . str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);
                        $languageId = $languages['languages_id'];
                        $tagChosen = false; // Initialize as false

                        // Check if the current tag ID exists in the user's chosen tags
                        foreach ($result as $currentlanguage) {
                            if ($currentlanguage['user_languages_languages_id'] == $languageId) {
                                $tagChosen = true;
                                break; // If found, no need to continue searching
                            }
                        }
                        if(!$tagChosen) {
                            ?>
                            <!-- Add hidden checkbox -->
                            <input type="checkbox" name="chosen_languages[]" value="<?= $languageId ?>" style="display: none;">
                            <span class="badge rounded-fill badge-clickable" style="background-color: <?= $color ?>" data-language-id="<?= $languageId ?>">
                    <?= $languages['languages_name'] ?>
                </span>
                        <?php } ?>
                    <?php } ?>
                </div>
                <script>
                    $(document).ready(function() {
                        // Click event handler for clickable badges
                        $('.badge-clickable').click(function() {
                            $(this).toggleClass('chosen');

                            // If the element is chosen, set border properties
                            if ($(this).hasClass('chosen')) {
                                $(this).css({
                                    'border-style' : 'solid',
                                    'border-width': 'medium',
                                });
                                $(this).css('border-color', 'blue');
                            } else {
                                // If the element is not chosen, reset border properties
                                $(this).css({
                                    'border-style' : '',
                                    'border-width': '',
                                });
                                $(this).css('color', 'white'); // Reset color
                            }
                            // Get the associated checkbox
                            var checkbox = $(this).prev('input[type="checkbox"]');
                            // Toggle the checkbox's checked state
                            checkbox.prop('checked', !checkbox.prop('checked'));
                        });

                    });
                </script>
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
            <form action="php/user_edit.php" method="post">
                <button type="submit" name="delete" id="delete" class="btn btn-danger">Delete</button>
            </form>
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
                    <label for="location" class="form-label">Language</label>
                    <button type="button" class="btn btn-primary" id="openModalButton">
                        Edit Languages
                    </button>
                    <br>
                    <button type="submit" class="btn btn-primary" id="edit">Edit</button>
                </form>
                <form action="php/mailer.php" method="post">
                    <?php if(isset($_POST['change_password'])) {
                        popupmessage('Change Password', 'Are you sure?', 'Continue');
                    } ?>
                    <input type="hidden" name="user_id" value="<?= $_SESSION['users_id'] ?>">
                </form>
                <form action="" method="post">
                    <td><button class="btn btn-primary" type="submit" name="change_password" value="<?= $_SESSION['users_id'] ?>">Change Password</button></td>
                </form>
            </div>
        </div>
        <div class="col-sm">
        </div>
    </div>
</div>