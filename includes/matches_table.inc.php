<?php
include 'private/conn.php';
require 'functions/popupmessage.php';
include 'functions/get_user_info.php';

$sql_matches_select = "SELECT likes_liked_user AS id1, likes_current_user AS id2, likes_is_unmatched
                        FROM tbl_likes 
                        WHERE likes_current_user = :user_id 
                        AND likes_liked_user IN 
                        (SELECT L.likes_current_user
                        FROM tbl_likes AS L 
                        INNER JOIN tbl_users AS U ON L.likes_liked_user = U.users_id 
                        WHERE likes_liked_user = :user_id)
                        AND likes_is_unmatched = 0";

$sth_matches_select = $db->prepare($sql_matches_select);
$sth_matches_select->bindParam(':user_id', $_SESSION['users_id']);
$sth_matches_select->execute();
$result = $sth_matches_select->fetchAll();

?>

<div class="container">
    <div class="row">
        <div class="col-3">
        </div>
        <div class="col-9">
            <h1>Matches Table
            </h1>

            <table>
                <tr>
                    <th>User Name</th>
                    <th>User Location</th>
                    <th>User Birthdate: </th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                <?php
                foreach($result as $user) {

                    $row = GetUserInfo($user['id1']);
                    ?>
                    <tr>
                        <td><?= $row['users_username'] ?></td>
                        <td><?= $row['users_city'] ?></td>
                        <td><?= $row['users_date_of_birth'] ?></td>
                        <?php
                        if(isset($_SESSION['users_role'])){
                            if($_SESSION['users_role'] == 0) {
                                ?>
                                <form action="index.php?page=chat&id=<?=$row['users_id']?>" method="post"><td><button class="btn btn-primary" type="submit" name="user_chat" value="<?= $row['users_id'] ?>">CHAT</button></td></form>
                                <form action="" method="post">
                                    <?php if(isset($_POST['unmatch_user'])) {
                                        popupmessage('Admin Delete', 'Are you sure?', 'Continue');
                                    } ?>
                                    <input type="hidden" name="user_unmatch" value="<?= $row['users_id'] ?>">
                                </form>
                                <form action="php/unmatch.php" method="post">
                                    <td><button class="btn btn-primary" type="submit" name="unmatch_user" value="<?= $row['users_id'] ?>">Unmatch</button></td>
                                </form>
                                <?php
                            }
                        }
                        ?>

                    </tr>

                    <?php
                }
                ?>


            </table>
        </div>
        <div class="col-3">
        </div>
    </div>

    <td><?php
        if(isset($_POST['role_id']))
        ?></td>