<?php

function multiFormTags($table) {

    include "private/conn.php";

    $sql = "SELECT * FROM " . $table . " ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    try {
        $sql2 = "SELECT * FROM tbl_usertags WHERE usertags_users_id = :user_id";
        $stmt2 = $db->prepare($sql2);
        $stmt2->bindParam(":user_id", $_SESSION['users_id']);
        $stmt2->execute();
        $user_tags = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo $e;
    }
    ?>
    <script>
        $(document).ready(function() {
            $('#close').on('click', function() {
                $('#error').hide();
            });
        });
            $(document).ready(function(){
            $('.badge-clickable').click(function(){
                $('#checkbox').toggle('checked');
            });
        });

    </script>
    <div class="" id="error" role="alert">
        <div class="container">
            <div>search</div>

            <?php

                foreach($result as $array) {
                        $color = isset($array["tags_color"]) ? $array["tags_color"] : "blue";


                        if(in_array($user_tags['usertags_tags_id'], $array)) {
                        }

                        ?>
                    <div class="container-sm">
                            <?php if(in_array($array['tags_id'], $user_tags)) { ?>
                        <span class="badge rounded-fill badge-clickable" style="background-color: <?= $color ?>"><?= $array['tags_title'] ?>
                            <input class="checkbox" type="checkbox" checked>
                        </span> <?php } else { ?>
                        <span class="badge rounded-fill badge-clickable" style="background-color: <?= $color ?>"><?= $array['tags_title'] ?>
                            <input class="checkbox" type="checkbox">
                        </span> <?php } ?>
                    </div>
            <?php

                }
             ?>

        </div>
    </div>
<?php
}