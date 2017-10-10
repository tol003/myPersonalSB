<?php
  include_once("db.php");

  $delete_user_id = $_POST['delete_id'];

  // make sure to delete all boards associated to the particular user;
  $delete_user_boards_associations = "DELETE FROM has_boards WHERE user_id='$delete_user_id'";
  $has_boards_query_result = $conn->query($delete_user_boards_associations);
  if (!$has_boards_query_result) {
    echo "<h1>A Database error occurred when querying all associated user boards of user to be deleted from database</h1>";
  } else {
    // Query to delete all associated user boards was successful, now delete user
    $delete_user = "DELETE FROM users WHERE user_id = '$delete_user_id'";
    $new_table_result = $conn->query($delete_user);
    if(!$new_table_result) {
      echo "<h1>A Database error occurred when trying to query delete user</h1>";
    }
  }
  $newURL = "http://138.68.46.83/crud/admin_page.php";
  header('Location: '.$newURL);
?>
