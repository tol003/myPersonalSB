<?php
  session_start();
  unset($_SESSION);
  session_destroy();
  session_write_close();

  $newURL = "landing.php";
  header('Location: '.$newURL);
  die;
?>
