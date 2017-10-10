<?php
  require_once("connection.php");

  $db = new Db();

  $results = ($db->userDeleteSound($_POST['sound_id']));

  $newURL = "private_sounds.php?sbid=". $_POST['sbid'];

  header("Location: " . $newURL);

  die();
?>