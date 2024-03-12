<?php

?>
<div class="container">
    <div class="row">
        <div class="col-sm">
        </div>

        <div class="col-sm">
            <h1>Insert Admin</h1>
            <form action="php/CRUD/admin_crud.php" method="post">
                <div class="mb-3">
                    <label for="first_name">First Name:</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Insert First Name" required>
                </div>
                <div class="mb-3">
                    <label for="preposition">Preposition:</label>
                    <input type="text" class="form-control" id="preposition" name="preposition" placeholder="Preposition"  required>
                </div>
                <div class="mb-3">
                    <label for="last_name">Last Name:</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Insert Last Name"  required>
                </div>
                <div class="mb-3">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Insert Email address"  required>
                </div>
                <div class="mb-3">

                </div>
                <input type="hidden" name="admin_add">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>

        <div class="col-sm">
        </div>

    </div>
</div>
