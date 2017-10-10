<?php
  include_once("db.php");

  if ($_POST['user_name_to_add']=='' or $_POST['password_to_add']=='' or $_POST['first_name_to_add']=='' or $_POST['last_name_to_add']=='' or $_POST['user_email_to_add']=='') {
    echo "<h1>One or more required fields are empty. Please fill all registration fields</h1>";
  } else {

    // query the user and update his fields
    $new_user_name = $_POST['user_name_to_add'];
    $new_password = $_POST['password_to_add'];
    $new_first_name = $_POST['first_name_to_add'];
    $new_last_name = $_POST['last_name_to_add'];
    $new_user_email = $_POST['user_email_to_add'];

    // We now check that the user is unique, we first query to check that the
    // new email to be added does not exist in the database already
    $is_new_email_unique = "SELECT * FROM users WHERE email='$new_user_email'";
    $unique_email_query_result = $conn->query($is_new_email_unique);
    if (!$unique_email_query_result) {
      echo "<h1>Database querying error when determining if new user email is in the database</h1>";
    } else {
      // No error in the database query, now, let's check if the return value is 0 or more
      $row = $unique_email_query_result->fetch_array(MYSQLI_NUM);
      if ($row) {
        // User email is already in the database
        echo "<h1>This email address is already in the database, try a different email address</h1>";
      } else {
        // User email is not in the database, so it is ok to add this new user to database
        $add_new_user_query = "INSERT INTO users SET
                  username = '$new_user_name',
                  password = PASSWORD('$new_password'),
                  first_name = '$new_first_name',
                  last_name = '$new_last_name',
                  email = '$new_user_email',
                  admin = '0'";


        $add_user_query_result = $conn->query($add_new_user_query);
        if (!$add_user_query_result) {
          echo "<h1>A Database error occurred when trying to insert new user to database</h1>";
          echo $conn->error;
        } else {
          // New user was added successfully to the database

        }
        //$add_user_query_result->free();
      }
    }
    //$unique_email_query_result->free();
  }
  $newURL = "http://138.68.46.83/crud/admin_page.php";
  header('Location: '.$newURL);
?>
