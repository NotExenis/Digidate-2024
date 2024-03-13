<?php
function succesmessage($message){
    ?>
    <script>
        $(document).ready(function() {
            $('#close').on('click', function() {
                $('#succes').hide();
            });
        });
    </script>
    <div class="alert alert-succes clearfix" id="succes" role="alert">
        <div class="d-flex justify-content-between">
            <?php echo $message ?>
            <button type="button" id="close" class="btn btn-close float-right" aria-label="Close"></button>
        </div>
    </div>
    <?php
}
?>
