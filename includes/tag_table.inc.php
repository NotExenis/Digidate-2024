<?php
include 'private/conn.php';

$sql_tag_select = "SELECT * FROM tbl_tags";
//$sql_admin_select = "SELECT users_id, users_first_name, users_preposition, users_last_name, users_email, users_is_admin, users_creation_date FROM tbl_users WHERE users_is_admin = 1 ";
$sth_tag_select = $db->prepare($sql_tag_select);
$sth_tag_select->execute();

?>
<style>
    .table-responsive {
        max-height: 500px;
    }
</style>
<?php
if(isset($_SESSION['users_role'])){
    if($_SESSION['users_role'] == 1) {
        ?>
<div class="container">
    <div class="row">
        <div class="col-3">
        </div>
        <div class="col-9">
            <h1>Tag Table        <a href="index.php?page=add_tag"><button class="btn btn-primary" >INSERT</button></a>
            </h1>
            <div class="table-responsive">
            <table>
                <tr>
                    <th>Tag</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                <?php

                while ($tags = $sth_tag_select->fetch(PDO::FETCH_ASSOC)) {
                    $color = isset($tags["tags_color"]) ? $tags["tags_color"] : "blue";
                    ?>
                    <tr>
                        <td>
                            <span class="badge rounded-fill badge-clickable" style="background-color: <?= $color ?>" data-tag-id="<?= $tags['tags_id'] ?>">
                                <?= $tags['tags_title'] ?>
                            </span>
                        </td>
                        <form action="index.php?page=tag_edit" method="post"><td><button class="btn btn-primary" type="submit" name="tag_edit" value="<?= $tags['tags_id'] ?>">EDIT</button></td></form>
                        <form action="php/tag_table.php" method="post"><td><button class="btn btn-primary" type="submit" name="tag_delete" value="<?= $tags['tags_id'] ?>">Delete</button></td></form>

                    </tr>

                <?php } ?>


            </table>
        </div>
        </div>
        <div class="col-3">
        </div>
    </div>
    <?php
        }else {
        header('location:index.php?page=login');
    }
    }
    ?>

    <td><?php
        if(isset($_POST['role_id']))
        ?></td>