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
                    <label for="exampleInputPassword1">Password</label>
                    <input type="text" class="form-control" id="password1" name="password1" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Re-enter password</label>
                    <input type="text" class="form-control" id="password2" name="password2" required>
                </div>
                <br>
                <input type="hidden" name="user_change_pass" value="<?= $id ?>">
                <button type="submit" class="btn btn-primary">Change Password</button>
            </form>
        </div>
        <div class="col-sm">
        </div>
    </div>
</div>