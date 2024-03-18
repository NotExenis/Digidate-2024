<?php

function multiForm($table) {

    include "private/conn.php";

    try {
        $sql = "SELECT * FROM " . $table . " ";
        $stmt = $db->prepare($sql);
        $stmt->execute();
    }  catch (Exception $e) {

    }
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
            <br>
            <?php
                foreach($result as $array) {
                    foreach($array as $key => $value) {
                        $prefix = strstr($key, '_', false);
                        ?>
                    <div class="">

                        <label><?= $prefix ?></label>
                        <label><?=$value?></label>
                    </div>
                        <br>
            <?php
                    }
                }
             ?>

        </div>
    </div>
<?php
}