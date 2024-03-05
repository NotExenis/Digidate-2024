<?php
include 'private/conn.php';
$sql_admin_select = "SELECT users_id, users_first_name, users_preposition, users_last_name, users_email, users_is_admin, users_creation_date FROM tbl_users WHERE users_id = :user_id";
$sth_admin_select = $conn->prepare($sql_admin_select);
$sth_admin_select->bindParam(":user_id", $_POST['admin_edit']);
$sth_admin_select->execute();
$result = $sth_admin_select->fetch();
?>

<div class="container">
    <div class="row">
        <div class="col-sm">
        </div>

        <div class="col-sm">
            <h1>Edit Admin</h1>
            <form action="php/CRUD/admin_crud.php" method="post">
                <div class="mb-3">
                    <label for="first_name">First Name:</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Insert First Name" value="<?= $result['users_first_name'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="preposition">Preposition:</label>
                    <input type="text" class="form-control" id="preposition" name="preposition" placeholder="Preposition" value="<?= $result['users_preposition'] ?>">
                </div>
                <div class="mb-3">
                    <label for="last_name">Last Name:</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Insert Last Name" value="<?= $result['users_last_name'] ?>"  required>
                </div>

                <div class="mb-3">
                </div>
                <input type="hidden" value="<?= $result['users_id'] ?>" name="admin_edit">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>

        <div class="col-sm">
        </div>

    </div>
</div>
