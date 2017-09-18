<?php
  session_start();

  if($_SESSION['fromLogin'] == '1'){

    unset($_SESSION['fromLogin']);
    require_once('action.php');
    $result = getUserInfo($_POST['user_email'], $_POST['password']);

    if($result){

    }
  }

  else{
    Header: "Location: landing.php";
  }
?>