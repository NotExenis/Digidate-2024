<?php
function errormessage($message){
    ?>
    <div class="alert alert-danger clearfix" role="alert">
        <?php echo $message ?>
        <button type="button" id="close" class="btn btn-close float-right" aria-label="Close"></button>
    </div>
<?php
}
?>

