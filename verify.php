<?php
  session_start();

  $user_req = '^\w{6,30}+$';
  $pass_req = '^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+])[a-zA-Z\d][a-zA-Z\d!@#$%^&*()_+]{7,}$';
  $user_input = $_POST['username'];
  $pass_input = $_POST['password'];
  $fname_input = $_POST['firstName'];
  $lname_input = $_POST['lastName'];
  $email_input = $_POST['user_email'];


  $_SESSION['user_temp'] = $user_input;
  $_SESSION['first_temp'] = $fname_input;
  $_SESSION['last_temp'] = $lname_input;
  $_SESSION['email_temp'] = $email_input;
  $_SESSION['pass_temp'] = $pass_input;


  if(preg_match($user_req, $user_input) == '0'){
    $_SESSION['user_error'] = '1';

    if(!isset($_SESSION['reg_errors'])){
      $_SESSION['reg_errors'] = '1';
    }
  }

  if(preg_match($pass_req, $pass_input) == '0'){
    $_SESSION['pass_error'] = '1';

    if(!isset($_SESSION['reg_errors'])){
      $_SESSION['reg_errors'] = '1';
    }
  }

  if(empty($fname_input)){
    $_SESSION['first_error'] = '1';

    if(!isset($_SESSION['reg_errors'])){
      $_SESSION['reg_errors'] = '1';
    }
  }

  if(empty($lname_input)){
    $_SESSION['last_error'] = '1';

    if(!isset($_SESSION['reg_errors'])){
      $_SESSION['reg_errors'] = '1';
    }
  }

  if(!filter_var($email_input, FILTER_VALIDATE_EMAIL)){
    $_SESSION['email_error'] = '1';

    if(!isset($_SESSION['reg_errors'])){
      $_SESSION['reg_errors'] = '1';
    }
  }

  if(isset($_SESSION['reg_errors'])){

    /*echo '<script>console.log("Inside reg error before going back to registration page")</script>';*/

    unset($_SESSION['reg_errors']);

    header('Location: registration.php');
  }

  else{
    require_once('action.php');
    insertUserInfo($user_input, $pass_input, $fname_input, $lname_input, $email_input);
  }

?>