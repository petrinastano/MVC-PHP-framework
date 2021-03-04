<!DOCTYPE html>
<html lang="sk">
  <head>
    <title><?php echo $title; ?></title>
    <meta charset="utf-8">
    <meta name="author" content="Stanislav Petrina" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow">
    <link rel="stylesheet" href="<?php echo BASE_DIR; ?>assets/css/basic.css" />
    <link rel="stylesheet" href="<?php echo BASE_DIR; ?>assets/css/template.css" />
     <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements media queries HTML5 fix media queries pre IE -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

 <body>

  <div class="top">
    <div class="container">
      <div class="grid-fix-1">
        <div class="logo">
          <a href="#">Logo</a>
        </div>

       <div class="input">
        <form action="#" method="post">
          <input type="text" name="search" />
          <input type="submit" name="submit" />
        </form>
      </div>
      </div>

      <div class="right panel">
        <ul>
          <li><a href="#"><span class="hide">User</span></a></li>
          <li><a href="#">Notif</a></li>
          <li><a href="#" class="radius-3">+ Udalosť</a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="menu">
    <div class="container">
        <div class="grid-fix-2">
          <nav>
           <ul>
             <li><a href="#">Koncerty</a></li>
             <li><a href="#" class="check">Festivaly</a></li>
             <li><a href="#">Zrazy</a></li>
             <li><a href="#">Sport</a></li>
             <li><a href="#">Zrazy</a></li>
             <li><a href="#" class="next">Sport<span>arrow</span></a></li>
           </ul>
         </nav>
        </div>

        <div class="right filter">
          <a href="#">FILTER</a>
        </div>
     </div>
  </div>
  
  <?php require(BASE_PATH.'app/view/'.$view.'.php'); ?>

 </body>
</html>