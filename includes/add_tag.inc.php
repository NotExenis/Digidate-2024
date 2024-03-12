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
            <form method="POST" action="php/add_tag.php">
                <div class="form-group">
                    <label for="exampleInputEmail1">Add a tag</label>
                    <input type="text" class="form-control" name="tag" placeholder="Tag name" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Add a color</label>
                    <input type="color" name="colorpick">
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Add tag</button>
            </form>
        </div>
        <div class="col-sm">
        </div>
    </div>
</div>