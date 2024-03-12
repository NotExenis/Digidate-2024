
<?php
function errormessage($message){
    ?>
        <script>
            $(document).ready(function() {
                $('#close').on('click', function() {
                    $('#error').hide();
                });
            });
        </script>
    <div class="alert alert-danger clearfix" id="error" role="alert">
        <div class="d-flex justify-content-between">
            <?php echo $message ?>
            <button type="button" id="close" class="btn btn-close float-right" aria-label="Close"></button>
        </div>
    </div>
<?php
}
?>

