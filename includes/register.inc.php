<?php 

require 'private/conn.php';

$sql_gender = "SELECT genders_name 
               FROM tbl_genders";
$stmt_gender = $db->prepare($sql_gender);
$stmt_gender->execute();

$sql_location = "SELECT municipality_name 
                 FROM tbl_municipalities";
$stmt_location = $db->prepare($sql_location);
$stmt_location->execute();
?>
<script src="./functions/showpass.js"></script>

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
            <div class="registration">
                <h1>Registration User</h1>
                <form action="php/register.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="firstname" class="form-label">Username *</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">infix</label>
                        <input type="text" class="form-control" name="infix">
                    </div>

                    <div class="mb-3">
                        <label for="firstname" class="form-label">First name *</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" required>
                    </div>

                    <div class="mb-3">
                        <label for="lastname" class="form-label">Last name *</label>
                        <input type="text" class="form-control" id="lastname" name="lastname">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Phone number *</label>
                        <input type="number" class="form-control" name="phone" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password *</label>
                        <input type="password" class="form-control" id="password"
                               title="Password must contain at least 15 characters, including at least one digit, one lowercase letter, one uppercase letter, and one special character."
                               pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()-_=+{};:,<.>]).{15,}$"
                               name="password" required>
                        <input type="checkbox" id="check">Show Password
                    </div>

                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender *</label>
                        <select class="form-select" name="gender" required>
                            <?php foreach($stmt_gender as $gender){ ?>
                                <option value="<?= $gender['genders_id']?>"><?= $gender['genders_name']?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label">Location *</label>
                        <select class="form-select" value="<?= $location['municipality_id'] ?>" name="location"
                                required>
                            <?php foreach ($stmt_location as $location) { ?>
                                <option><?= $location['municipality_name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="photo" class="form-label">Photo</label>
                        <input type="file" class="form-control" id="photo" name="photo">
                    </div>

                    <div class="mb-3">
                        <label for="age" class="form-label">Date of Birth *</label>
                        <input type="date" class="form-control" id="age" name="age"
                               max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<div class="col-sm">
</div>
</div>
</div>


