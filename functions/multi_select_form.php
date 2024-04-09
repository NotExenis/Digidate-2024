<?php

function multiFormTags() {

    include "private/conn.php";

    $sql = "SELECT * FROM tbl_tags";
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
    <div class="position-absolute translate-middle-x" id="error" role="alert">
        <div class="d-flex container">
            <div>search</div>
            <div class="row">
                <?php
                $x = 0;
                foreach($result as $array) {
                    ?>
                    <div class="col"> <!-- Adjust col-md-3 according to your layout -->
                        <?php
                        $color = isset($array["tags_color"]) ? $array["tags_color"] : "blue";
                        if(isset($user_tags[$x])) {
                            if($user_tags[$x] != null) {
                                ?>
                                <span class="badge rounded-fill badge-clickable" style="background-color: <?= $color ?>"><?= $array['tags_title'] ?>
                            <input class="checkbox" type="checkbox" checked>
                        </span>
                                <?php
                            }
                        } else {
                            ?>
                            <span class="badge rounded-fill badge-clickable" style="background-color: <?= $color ?>"><?= $array['tags_title'] ?>
                        <input class="checkbox" type="checkbox">
                    </span>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                    $x++;
                }
                ?>
            </div>
        </div>
        <button type="button" id="close" class="btn btn-close float-right" aria-label="Close"></button>

    </div>
<?php
}