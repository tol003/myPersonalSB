<?php
  session_start();

  if($_SESSION['fromLogin'] == '1'){

    unset($_SESSION['fromLogin']);
    require_once('action.php');
    getUserInfo($_POST['user_email'], $_POST['password']);
  }

  Header: "Location: landing.php";
?>