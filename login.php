<?php
  //include("common.php");  // include the error function from common.php
  include_once("db.php");      // include the basic dbConnect function from db.php
  //include_once("connection.php");
  //$conn_string = new Db();
  session_start();
  // on initial page request, session will be started, and the user-id and the
  // user password will be set to the session variables. On a log-in action, the
  // user-id and password will be set the the $_POST values.
  if (isset($_POST['user_email'])) {
    $user_email = $conn->real_escape_string($_POST['user_email']);
  } else {
    $user_email = $conn->real_escape_string($_SESSION['user_email']);
  }

  if (isset($_POST['user_password'])) {
    $user_password = $conn->real_escape_string($_POST['user_password']);
  }

  // if user-id or password is not set, show the log-in page.
  if (!isset($user_email) or !isset($user_password)) {
    ?>
      <!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>SoundBoard Login Page</title>
        </head>
        <body>
          <h1>Please Log in</h1>
          <form method="post" action="<?=$_SERVER['PHP_SELF']?>">
            <label for="user_email">Email Address:</label>
            <input type="text" name="user_email"><br>
            <label for="password">Password:</label>
            <input type="password" name="user_password"><br>
            <input type="submit" name="submit_button" value="Log in">
          </form>
        </body>
      </html>
   <?php
   exit;
  }
  $_SESSION['user_email'] = $conn->real_escape_string($user_email);


  $sql = "SELECT * FROM users WHERE email = '$user_email' AND password = PASSWORD('$user_password')";
  $result = $conn->query($sql);

  if (!$result) {
      echo "<h1>A Database error occurred while checking your log-in details</h1>";
      echo $conn->error;

        $log = "\n[LOGIN ATTEMPT]:LOGIN <> [IP]:".$_SERVER['REMOTE_ADDR']." <> [DATE]:"
          .date("F j, Y, g:i a")." <> [STATUS]: **FAIL**\n";
           file_put_contents("/var/www/logs/log_".date("j.n.Y")."txt",$log,FILE_APPEND);

      exit;
  } else {
    $row = $result->fetch_array(MYSQLI_NUM);
    if ($row) {
      // user was found, so now we set the $_SESSION['user_id'] to the user's id from database
      $user_id_search = "SELECT user_id, first_name, last_name, admin FROM users WHERE email = '$user_email'";
      $user_id_query_result = $conn->query($user_id_search);
      if (!$user_id_query_result) {
        echo "<h1>A Database error occurred while querying for user-id</h1>";
          // LOGGING FAILED LOGIN
         $log = "\n[LOGIN ATTEMPT]:LOGIN <> [IP]:".$_SERVER['REMOTE_ADDR']." <> [DATE]:".
           date("F j, Y, g:i a")." <> [STATUS]: **FAIL**\n";
           file_put_contents("/var/www/logs/log_".date("j.n.Y")."txt",$log,FILE_APPEND);

           exit;
      } else {
        $row = $user_id_query_result->fetch_array(MYSQLI_NUM);
        if ($row) {
          // User-id was returned from database, so now we set the $_SESSION['user_id']
          $_SESSION['user_id'] = $row[0];
          $_SESSION['user_first_name'] = $row[1];
          $_SESSION['user_full_name'] = $row[1] . " " . $row[2];
          $_SESSION['admin'] = $row[3];
          // LOGGING SUCCESSFUL LOGIN
         $log ="\n[LOGIN ATTEMPT]:LOGIN <> [IP]:".$_SERVER['REMOTE_ADDR']." <> [DATE]:".
           date("F j, Y, g:i a")." <> [STATUS]: **SUCCESS**\n";
           file_put_contents("/var/www/logs/log_".date("j.n.Y")."txt",$log,FILE_APPEND);
        } else {
          // User-id was not returned from database, so we exit the script

         // LOGGING FAILED LOGIN
         $log = "\n[LOGIN ATTEMPT]:LOGIN <> [IP]:".$_SERVER['REMOTE_ADDR']." <> [DATE]:".
           date("F j, Y, g:i a")." <> [STATUS]: **FAIL**\n";
           file_put_contents("/var/www/logs/log_".date("j.n.Y")."txt",$log,FILE_APPEND);

          exit;
        }
      }
      $newURL = "http://138.68.46.83/crud/index.php";
      header('Location: '.$newURL);
    } else {
      // user was not found
      unset($_SESSION['user_email']);
      unset($_SESSION['user_id']);
      unset($_SESSION['user_full_name']);
      unset($_SESSION['admin']);
      // html and add a link for registration page

           // LOGGING FAILED LOGIN
         $log = "\n[LOGIN ATTEMPT]:LOGIN <> [IP]:".$_SERVER['REMOTE_ADDR']." <> [DATE]:".
           date("F j, Y, g:i a")." <> [STATUS]: **FAIL**\n";
           file_put_contents("/var/www/logs/log_".date("j.n.Y")."txt",$log,FILE_APPEND);



      ?>
        <!DOCTYPE html>
        <html>
          <head>
            <meta charset="utf-8">
            <title>Access Denied</title>
          </head>
          <body>
            <h1>Access Denied</h1>
            <p>Your user ID or password is incorrect. To try logging in again,
               click <a href="<?=$_SERVER['PHP_SELF']?>">here</a>. To register
               for access, click <a href="registration.php">here</a>
            </p>
          </body>
        </html>
        <?php
        exit;
    }
  }
?>
