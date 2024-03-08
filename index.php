<?php
session_start();


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
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <title><?php if (isset($page)) { echo $page; } else {echo "Home";}?></title>             
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