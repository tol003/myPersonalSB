<?php
  session_start();
  unset($_SESSION);
  session_destroy();
  session_write_close();
   // LOGGING FAILED LOGIN
  /*$log = "\n[LOGIN ATTEMPT]:LOGOUT <> [IP]:".$_SERVER['REMOTE_ADDR']." <> [DATE]:".
     date("F j, Y, g:i a")." <> [STATUS]: ****\n";
  file_put_contents("/var/www/logs/log_".date("j.n.Y")."txt",$log,FILE_APPEND);*/
 
  $newURL = "landing.php";
  header('Location: '.$newURL);
  die;
?>
