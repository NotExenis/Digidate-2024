<?php

?>

<div>
    <div class="container">
        <h1>Insert Admin</h1>
        <form action="../php/CRUD/admin_crud.php" method="post">
            <label>First Name:</label><input name="first_name">
            <label>Preposition: </label><input name="preposition">
            <label>Last Name:</label><input name="last_name">
            <label>Email: </label><input name="email">
            <input type="hidden" name="crud_method" value="admin_add">
            <button type="submit">Submit</button>
        </form>
    </div>
</div>
