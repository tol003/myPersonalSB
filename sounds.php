<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sounds</title>
  <?php
    include('header.php');
  ?>
</head>
<body>
  <div class="nav-container">
    <ul>
      <li><a href="./landing.php"><div>Soundboards</div></a>
        <div>
          <ul>
            <li><a href="./landing.php">Public</a></li>
            <?php if(isset($_SESSION['email'])): ?>
              <li><a href="./private_SB.php">Private</a></li>
            <?php endif; ?>
          </ul>
        </div>
      </li>
      <?php if(isset($_SESSION['email'])): ?>
        <li><a href="./logout.php"><div>Log Out</div></a>
        </li>
      <?php endif; ?>
      <?php if ($_SESSION['admin']=='1'): ?>
        <li><a href="./admin_page.php"><div>Admin</div></a>
        </li>
      <?php endif ?>
    </ul>
    <?php
      if(isset($_SESSION['email'])){
        echo '<p class="login" id="hello">Hello, '. $_SESSION['first_name'] .'</p>';
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
  <h1>Public Sounds</h1>
  <hr>
  <div id="sound-container">
    <?php
      require_once("action.php");
      getSounds($_GET['sbid']);
    ?>
  </div>
</body>
</html>
