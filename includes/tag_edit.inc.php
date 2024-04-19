<?php
include 'private/conn.php';
$sql_tag_select = "SELECT * FROM tbl_tags WHERE tags_id = :tags_id";
$sth_tag_select = $db->prepare($sql_tag_select);
$sth_tag_select->bindParam(":tags_id", $_POST['tag_edit']);
$sth_tag_select->execute();
$result = $sth_tag_select->fetch();

?>
<div class="container">
    <div class="row">
        <div class="col-sm">
        </div>
        <div class="col-sm">
            <form method="POST" action="php/tag_table.php">
                <br>
                <div class="form-group">
                    <label for="exampleInputEmail1">Edit tag</label>
                    <input type="text" class="form-control" name="tags_title" placeholder="Tag name" value="<?= $result['tags_title'] ?>" required>
                </div>
                <br>
                <div class="form-group">
                    <label for="exampleInputEmail1">Add a color</label>
                    <input type="color" name="tags_color" value="<?= $result['tags_color'] ?>">
                </div>
                <br>
                <input type="hidden" name="tag_edit" value="<?= $result['tags_id'] ?>">
                <button type="submit" class="btn btn-primary" name="tags_id" value="<?= $result['tags_id'] ?>">Edit tag</button>
            </form>
        </div>
        <div class="col-sm">
        </div>
    </div>
</div>
