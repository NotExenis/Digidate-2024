<?php
include '../private/conn.php';

?>

<div>
    <table>
        <tr>
            <th>Admin Name</th>
            <th>Admin Email</th>
            <th>Admin creation date: </th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        <?php

        //$sql_admin_select = "SELECT users_first_name, users_preposition, users_last_name, users_email, users_is_admin FROM tbl_users WHERE users_is_admin = ". $_SESSION['role'] . " ";
        $sql_admin_select = "SELECT users_first_name, users_preposition, users_last_name, users_email, users_is_admin FROM tbl_users WHERE users_is_admin = 1 ";
        $sth_admin_select = $conn->prepare($sql_admin_select);
        $sth_admin_select->execute();

        while ($row = $sth_admin_select->fetch(PDO::FETCH_ASSOC)) {
            ?>
        <tr>
            <td><?= $row['users_first_name'] . ' ' . $row['users_preposition'] . ' ' . $row['users_last_name'] ?></td>
            <td><?= $row['users_email'] ?></td>
            <td><button>EDIT</button></td>
            <td><button>DELETE</button></td>
        </tr>

<?php } ?>


    </table>
</div>

<td><?php
    if(isset($_POST['role_id']))
    ?></td>