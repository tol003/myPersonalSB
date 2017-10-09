<?php
  session_start();

  if(!isset($_SESSION['email'])){
    header('Location: landing.php');
  }

  if(isset($_SESSION['email'])){
           // LOGGING SOUNDBOARD ACCESS
           /*$log = "\n[DATA ACCESS]:SOUNDBOARD <> [IP]:".$_SERVER['REMOTE_ADDR']." <> [DATE]:".
           date("F j, Y, g:i a")." <> [SB_ID]:".$_GET["sbid"]."\n";
           file_put_contents("/var/www/logs/log_".date("j.n.Y")."txt",$log,FILE_APPEND);*/
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
          <li><a href="/crud/index.php"><div>Soundboards</div></a>
            <div>
              <ul>
                <li><a href="/crud/index.php">Public</a></li>
                <li><a href="/crud/private_SB.php">Private</a></li>
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
          echo '<p class="login" id="hello">'. $_SESSION['user_first_name'] .'</p>';
        ?>
      </div>
      <h1>Private Sounds</h1>
      <hr>
      <div id="sound-container">
        <?php
          require_once("action.php");
          getPrivateSounds($_GET['sbid']);
        echo  '<div>
                  <p>  </p>
                   <a id="add_btn" title="Add Sound"
                   href="/crud/soundupload.php?sbid='.$_GET["sbid"].'">
                    <img src="/crud/sb_images/addbtn.png"> </a>
                 </div>';
        ?>
      </div>
    </body>
    </html>
<?php
  }

  else{
    header('Location: landing.php');
  }
?>