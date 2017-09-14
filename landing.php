<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>v2 Soundboard</title>
  <link rel="stylesheet" href="./sb.css">
  <script src="./sb.js"></script>
</head>
<body>
  <div class="nav-container">
    <ul>
      <li><a href="/crud/index.php"><div>Soundboards</div></a>
        <div>
          <ul>
            <li><a href="/crud/index.php">Public</a></li>
            <?php
              if($_SESSION['user_email']){
                echo '<li><a href="/crud/private_SB.php">Private</a></li>';
              }
            ?>
          </ul>
        </div>
      </li>
      <?php if (isset($_SESSION['user_email'])): ?>
        <li><a href="/crud/log_out.php"><div>Log Out</div></a>
        </li>
      <?php endif ?>
      <?php if ($_SESSION['admin']=='1'): ?>
        <li><a href="/crud/admin_page.php"><div>Admin</div></a>
        </li>
      <?php endif ?>
    </ul>
    <?php
      if($_SESSION['user_email']){
        echo '<p class="login" id="hello">Hello, '. $_SESSION['user_first_name'] .'</p>';
      }

      else{
        echo '<form id="register" action="/crud/registration.php" method="get">
          <input type="submit" value="Register">
        </form>
        <form class="login" action="/crud/login.php" method="get">
          <input type="submit" value="Login">
        </form>';
      }
    ?>
   </div>