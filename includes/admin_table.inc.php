<?php
include 'private/conn.php';

//NOTES: MELDING HIER

//NOTES: BEVESTIGING HIER

?>

<div class="container">
    <div class="row">
        <a href="index.php?page=admin_insert"><button class="btn btn-primary" >INSERT</button></a>
        <div class="col-3">
        </div>
        <div class="col-9">
            <h1>Admin Table</h1>
            <table>
                <tr>
                    <th>Admin Name</th>
                    <th>Admin Email</th>
                    <th>Admin creation date: </th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                <?php
                $_SESSION['user_role'] = 'admin';
                //$sql_admin_select = "SELECT users_first_name, users_preposition, users_last_name, users_email, users_is_admin FROM tbl_users WHERE users_is_admin = ". $_SESSION['role'] . " ";
                $sql_admin_select = "SELECT users_id, users_first_name, users_preposition, users_last_name, users_email, users_is_admin, users_creation_date FROM tbl_users WHERE users_is_admin = 1 ";
                $sth_admin_select = $conn->prepare($sql_admin_select);
                $sth_admin_select->execute();

                while ($row = $sth_admin_select->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                <tr>
                    <td><?= $row['users_first_name'] . ' ' . $row['users_preposition'] . ' ' . $row['users_last_name'] ?></td>
                    <td><?= $row['users_email'] ?></td>
                    <td><?= $row['users_creation_date'] ?></td>
                    <?php
                        if(isset($_SESSION['user_role'])){
                           if($_SESSION['user_role'] == 'admin') {
                               ?>
                               <form action="index.php?page=admin_edit" method="post"><td><button class="btn btn-primary" type="submit" name="admin_edit" value="<?= $row['users_id'] ?>">EDIT</button></td></form>
                               <form action="php/CRUD/admin_crud.php" method="post"><td><button class="btn btn-primary" type="submit" name="admin_delete" value="<?= $row['users_id'] ?>">Delete</button></td></form>
                    <?php
                           }
                        }
                    ?>

                </tr>

            <?php } ?>


            </table>
        </div>
        <div class="col-3">
        </div>
    </div>

<td><?php
    if(isset($_POST['role_id']))
    ?></td>