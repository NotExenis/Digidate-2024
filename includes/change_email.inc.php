<?php
require 'functions/errormessage.php';
if(isset($_SESSION['error_message'])) {
    //print_r($_SESSION);
    errormessage($_SESSION['error_message']);
    unset($_SESSION['error_message']);
}
$id = $_GET['user_id'];
?>

<div class="container">
    <div class="row">
        <div class="col-sm">

        </div>
        <div class="col-sm">
            <form method="POST" action="php/CRUD/user_crud.php">
                <div class="form-group">
                    <label for="exampleInputPassword1">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <br>
                <input type="hidden" name="user_change_email" value="<?= $id ?>">
                <button type="submit" class="btn btn-primary">Change Email</button>
            </form>
        </div>
        <div class="col-sm">
        </div>
    </div>
</div>