<!DOCTYPE html>
<html lang="sk">
  <head>
    <title><?php echo $title; ?></title>
    <meta charset="utf-8">
    <meta name="author" content="Stanislav Petrina" />
    <meta name="description" content="lorem ipsum dolor sit amet">
    <meta name="keywords" content="lorem ipsum amet elit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow">
    <link rel="stylesheet" href="<?php echo BASE_DIR; ?>/assets/css/basic.css" />
    <link rel="stylesheet" href="<?php echo BASE_DIR; ?>/assets/css/login.css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries HTML5 fix media queries pre IE -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

 <body>
  
  <?php require(BASE_PATH.'app/view/'.$view.'.php'); ?>

 </body>
</html>