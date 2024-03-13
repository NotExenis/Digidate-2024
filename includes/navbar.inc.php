<?php
if(isset($_SESSION['users_role'])){
    if($_SESSION['users_role'] == '1'){ //Admin
        $navitems = array(
            array('logout', 'Logout'),
            array('admin_table', 'Admin Table'),

        );
    } elseif ($_SESSION['users_role'] == '0'){ //User
        $navitems = array(
            array('logout', 'Logout'),
        );
    } 
} else {
    $navitems = array(
        array('login', 'Login'),
        array('register', 'Register'),
    );
}


?>

<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <ul class="navbar-nav">
        <?php foreach ((array)$navitems as $navitem) { ?>
            <li class="nav-item">
                <a class="font-weight-bold nav-link text-light" href="index.php?page=<?= $navitem[0] ?>"><?= $navitem[1] ?></a>
            </li>
        <?php } ?>
    </ul>
</nav>