<script src="./functions/showpass.js"></script>
<?php
require "functions/errormessage.php";

if(isset($_SESSION['notification'])) {
$error = $_SESSION['notification'];
errormessage($error);
unset($_SESSION['notification']);
}
?>
<div class="container">
    <div class="row">
        <div class="col-sm">
        <?php
            if (isset($_SESSION['notification'])) {
                echo '<p class="text-red-500">' . $_SESSION['notification'] . '</p>';
                unset($_SESSION['notification']);
            }
            ?>
        </div>
        <div class="col-sm">
            <form method="POST" action="php/login.php">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" name="email" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                    <input type="checkbox" id="check">Show Password
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
        <div class="col-sm">
        </div>
    </div>
</div>