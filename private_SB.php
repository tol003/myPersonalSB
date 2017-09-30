<?php
  require_once("connection.php");
  session_start();

  if(!isset($_SESSION['email'])){
    header('Location: landing.php');
  }

  if($_SESSION['email']){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

      $user_id = $_SESSION['user_id'];

      $db = new Db();
      $board_name = $_POST['sb_name'];
      $status   = $_POST['status'];
      $result = $db ->userCreateSB($user_id,$board_name,$status);

      Header("Location: private_SB.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>v2.1 Soundboard</title>
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
              <li><a href="./private_sb.php">Private</a></li>
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
      echo '<p class="login" id="hello">Hello, '. $_SESSION['first_name'] .'</p>';
    ?>
  </div>
  <h1>Private Soundboards</h1>
  <table id="soundboard-container">
    <tbody>
      <tr id="table-heading">
        <th id="sb-image">Board Images</th>
        <th id="sb-title">Board Titles</th>
      </tr>
      <?php
        require_once("action.php");
        getSB($_SESSION['user_id']);
      ?>
    </tbody>
  </table>
</body>
</html>
<?php
  }

  else{
    Header: "Location: login.php";
  }
?>
