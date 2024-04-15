<?php
include 'private/conn.php';
require 'functions/popupmessage.php';


$sql_admin_select = "SELECT users_id, users_first_name, users_preposition, users_last_name, users_email, users_is_admin, users_creation_date FROM tbl_users WHERE users_is_admin = ". $_SESSION['users_role'] . " ";
//$sql_admin_select = "SELECT users_id, users_first_name, users_preposition, users_last_name, users_email, users_is_admin, users_creation_date FROM tbl_users WHERE users_is_admin = 1 ";
$sth_admin_select = $db->prepare($sql_admin_select);
$sth_admin_select->execute();


?>

<div class="container">
    <div class="row">
        <div class="col-3">
        </div>
        <div class="col-9">
            <h1>Admin Table
                <a href="index.php?page=admin_insert"><button class="btn btn-primary" >INSERT</button></a>
            </h1>
            <table>
                <tr>
                    <th>Admin Name</th>
                    <th>Admin Email</th>
                    <th>Admin creation date: </th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                <?php

                while ($row = $sth_admin_select->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                <tr>
                    <td><?= $row['users_first_name'] . ' ' . $row['users_preposition'] . ' ' . $row['users_last_name'] ?></td>
                    <td><?= $row['users_email'] ?></td>
                    <td><?= $row['users_creation_date'] ?></td>
                    <?php
                        if(isset($_SESSION['users_role'])){
                           if($_SESSION['users_role'] == 1) {
                               ?>
                               <form action="index.php?page=admin_edit" method="post"><td><button class="btn btn-primary" type="submit" name="admin_edit" value="<?= $row['users_id'] ?>">EDIT</button></td></form>
                               <form action="php/CRUD/admin_crud.php" method="post">
                                   <?php if(isset($_POST['admin_delete'])) {
                                       popupmessage('Admin Delete', 'Are you sure?', 'Continue');
                                   } ?>
                                   <input type="hidden" name="admin_delete" value="<?= $row['users_id'] ?>">
                               </form>
                                   <form action="" method="post">
                                   <td><button class="btn btn-primary" type="submit" name="admin_delete" value="<?= $row['users_id'] ?>">Delete</button></td>
                               </form>
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