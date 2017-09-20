<?php
  session_start();

  require_once('action.php');
  
  getUserInfo($_POST['user_email'], $_POST['password']);

  header('Location: landing.php');
?>