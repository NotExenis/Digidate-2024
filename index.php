<?php
session_start();

include 'php/check_auction.php';

if(isset($_GET['page'])){
  if($_GET['page'] == 'logout'){
    header('location: php/logout.php');
    die();
  }else{
    $page = $_GET['page'];
  }
}
else{
  $page = "login";
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php if (isset($page)) { echo $page; } else {echo "Home";}?></title>                                                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>                                                        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link href="style/style.css" rel="stylesheet">
</head>
<body class="bg-secondary">
  <?php
    include 'includes/navbar.inc.php';
    include 'includes/'.$page.'.inc.php';
  ?>
</body>
</html>