<?php
  include_once("db.php");

  if ($_POST['user_name']=='' or $_POST['user_password']=='' or $_POST['user_first_name']=='' or $_POST['user_last_name']=='' or $_POST['user_email']=='') {
    echo "<h1>One or more required fields are empty. Please fill all registration fields</h1>";
  } else {


    // query the user and update his fields
    $edit_user_id = $_POST['user_id_to_edit'];
    $new_user_name = $_POST['user_name'];
    $new_password = $_POST['user_password'];
    $new_first_name = $_POST['user_first_name'];
    $new_last_name = $_POST['user_last_name'];
    $new_user_email = $_POST['user_email'];

    echo "The id of the user to be edited " . $edit_user_id;
    //echo "THE " . $new_user_name . "" . $new_password . "" . $new_first_name . "" . $new_last_name;
    //$edit_user_by_id = "UPDATE users SET username='$new_user_name', password='$new_password', first_name = '$new_first_name', last_name='$new_last_name' WHERE user_id='$edit_user_id'";
    $edit_user_by_id = "UPDATE users SET username='$new_user_name', password=PASSWORD('$new_password'), first_name = '$new_first_name', last_name='$new_last_name', email='$new_user_email' WHERE user_id='$edit_user_id'";
    $edit_user_query = $conn->query($edit_user_by_id);
    if (!$edit_user_query) {
        echo "<h1>Database querying error. Database could not find this particular user</h1>";
    } else {
      echo "SUCCESS";
    }
    echo "Hello world";
  }
  $newURL = "http://138.68.46.83/crud/admin_page.php";
  header('Location: '.$newURL);
?>
