<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login v2 Soundboard</title>
  <link rel="stylesheet" href="./css/main.css">
  <script src="./js/main.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Lora" rel="stylesheet">
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
<body id="login-body">
  <div class="nav-container">
    <div id="logo"></div>
    <ul>
      <li><a href="./landing.php"><div>Soundboards</div></a>
        <div>
          <ul>
            <li><a href="./landing.php">Public</a></li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
  <div id="login-container">
    <form id="login-form" action="./login_retrieve.php" method="post">
      <div>
        <?php
          if($_SESSION['reg_complete'] == '1'){
            unset($_SESSION['reg_complete']);
            echo '<h4 id="log-reg-confirm">Registration complete. Please sign in to continue.</h4>';
          }

          else{
            echo '<h4>Please sign in to continue.</h4>';
          }
        ?>
      </div>
      <hr>
      <label id="email">
        <input id="uEmail" type="text" name="user_email" placeholder=" Email" value="">
      </label>
      <label id="pass">
        <input id="pWord" type="password" name="password" placeholder=" Password" value="">
      </label>
      <input id="logBtn" type="submit" name="loginBtn" value="Login">
    </form>
    <form id="log-regForm" action="./registration.php" method="get">
      <p id="reg-p">Don't have an account yet?</p>
      <input id="log-regBtn" type="submit" value="Register">
    </form>
    <?php
      if($_SESSION['login_error'] == '1'){
        echo '<p id="err-msg">*Sorry, there was an error with the username or password while logging in. Please try again.*</p>';
        unset($_SESSION['login_error']);
      }
    ?>
  </div>
</body>
</html>