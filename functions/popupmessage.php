<?php
function popupmessage($title, $message, $buttontext){
    ?>
    <script>
        $(document).ready(function() {
            $('#close').on('click', function() {
                $('#popup').hide();
            });
            $('#cancel').on('click', function() {
                $('#popup').hide();
            });
        });
    </script>

    <div id="popup" class="container position-absolute top-10 start-50 translate-middle-x">
    <div class="row">
    <div class="col-sm"></div>
    <div class="col-sm">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                <h5 class="card-title"><?php echo $title ?></h5>
                    <button type="button" id="close" class="btn btn-close pull-right" aria-label="Close"></button>
                </div>
                <hr>
                <p class="card-text"><?php echo $message ?></p>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary m-1"><?php echo $buttontext ?></button>
                    <button type="submit" id="cancel" class="btn btn-danger m-1">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm"></div>
    </div>
</div>

    <?php
}
?>
