<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>v2 Soundboard</title>
  <link rel="stylesheet" href="./css/landing.css">
</head>
<body>
  <div class="nav-container">
    <div id="logo"></div>
    <ul>
      <li><a href="./landing.php"><div>Soundboards</div></a>
        <div>
          <ul>
            <li><a href="./landing.php">Public</a></li>
            <?php if(isset($_SESSION['user_email'])): ?>
              <li><a href="./private_SB.php">Private</a></li>
            <?php endif; ?>
          </ul>
        </div>
      </li>
      <?php if(isset($_SESSION['user_email'])): ?>
        <li><a href="/crud/log_out.php"><div>Log Out</div></a>
        </li>
      <?php endif; ?>
      <?php if ($_SESSION['admin']=='1'): ?>
        <li><a href="./admin_page.php"><div>Admin</div></a>
        </li>
      <?php endif ?>
    </ul>
    <?php
      if(isset($_SESSION['user_email'])){
        echo '<p class="login" id="hello">Hello, '. $_SESSION['user_first_name'] .'</p>';
      }

      else{
        echo '<form id="register" action="./registration.php" method="get">
          <input type="submit" value="Register">
        </form>
        <form id="login" action="./login.php" method="get">
          <input type="submit" value="Sign in">
        </form>';
      }
    ?>
  </div>
  <h1>Public Soundboards</h1>
  <hr>
  <table id="soundboard-container">
    <tr id="table-heading">
      <th id="sb-image">Board Images</th>
      <th id="sb-title">Board Titles</th>
      <th></th>
    </tr>
    <?php
      require_once('action.php');
      createLanding();
    ?>
</body>
</html>