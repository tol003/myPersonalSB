<?php
  session_start();

  require_once("connection.php");

  $db = new Db();

  if($_SESSION['admin']){
    $result = ($db->adminDeleteSB($_POST["sbid"]));
    $newURL = "./landing.php";
  }

  else{
    $result = ($db->userDeleteSB($_SESSION['user_id'], $_POST["sbid"]));
    $newURL = "./private_SB.php";
  }

  header("Location: " . $newURL);

  die;
?>
