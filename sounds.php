<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sounds</title>
  <link rel="stylesheet" href="./css/main.css">
  <script src="./js/main.js"></script>
  <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
  <link rel="apple-touch-icon" sizes="57x57" href="./site_images/favicon/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="./site_images/favicon/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="./site_images/favicon/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="./site_images/favicon/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="./site_images/favicon/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="./site_images/favicon/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="./site_images/favicon/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="./site_images/favicon/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="./site_images/favicon/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="./site_images/favicon/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="./site_images/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="./site_images/favicon/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="./site_images/favicon/favicon-16x16.png">
  <link rel="manifest" href="./site_images/favicon/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="./site_images/favicon/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">
</head>
<body>
  <div class="nav-container">
    <ul>
      <li><a href="./landing.php"><div>Soundboards</div></a>
        <div>
          <ul>
            <li><a href="./landing.php">Public</a></li>
            <?php if(isset($_SESSION['user_email'])): ?>
              <li><a href="./private_SB.php">Private</a></li>
            <?php endif ?>
          </ul>
        </div>
      </li>
      <?php if (isset($_SESSION['user_email'])): ?>
        <li><a href="./log_out.php"><div>Log Out</div></a>
        </li>
      <?php endif ?>
      <?php if ($_SESSION['admin']=='1'): ?>
        <li><a href="./admin_page.php"><div>Admin</div></a>
        </li>
      <?php endif ?>
    </ul>
    <?php
      echo '<p class="login" id="hello">'. $_SESSION['user_first_name'] .'</p>';
    ?>
  </div>
  <h1>Public Sounds</h1>
  <hr>
  <div id="sound-container">
    <?php
      require_once("action.php");
      getSounds($_GET['sbid']);

           /*// LOGGING SOUNDBOARD ACCESS
           $log = "\n[DATA ACCESS]:SOUNDBOARD <> [IP]:".$_SERVER['REMOTE_ADDR']." <> [DATE]:".
           date("F j, Y, g:i a")." <> [SB_ID]:".$_GET["sbid"]."\n";
           file_put_contents("/var/www/logs/log_".date("j.n.Y")."txt",$log,FILE_APPEND);*/
    ?>
  </div>
</body>
</html>
