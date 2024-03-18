<?php

function multiForm($table) {

    include "private/conn.php";

    $name = $table . '_name';
    $title = $table . '_title';
    $id = $table . '_id';
    $table_name = 'tbl_' . $table;

    try {
        $sql = "SELECT " . $name . " " . " $id " . "FROM " . $table_name . " ";
        $stmt = $db->prepare($sql);
        $stmt->execute();
    }  catch (Exception $e) {

    }
    try {
        $sql = "SELECT " . $title . " " . " $id " . "FROM " . $table_name . " ";
        $stmt2 = $db->prepare($sql);
        $stmt2->execute();
    }  catch (Exception $e) {

    }
    if($stmt) {
        $array = $stmt->fetchAll();
    } elseif($stmt2) {
        $array = $stmt2->fetchAll();
    }
    ?>
    <script>
        $(document).ready(function() {
            $('#close').on('click', function() {
                $('#error').hide();
            });
        });
    </script>
    <div class="" id="error" role="alert">
        <div class="d-flex justify-content-between">
            <div>search</div>
            <?php if(isset($table)) {

                    foreach($array as $key => $value) {?>

                    <div>
                        <label><?=$value?></label>
                    </div>
            <?php
                    }

            } ?>

        </div>
    </div>
<?php
}