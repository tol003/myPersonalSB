<?php
  session_start();

  $user_req = '^\w{6,30}+$';
  $pass_req = '^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+])[a-zA-Z\d][a-zA-Z\d!@#$%^&*()_+]{7,}$';
  $user_input = $_POST['username'];
  $fname_input = $_POST['firstName'];
  $lname_input = $_POST['lastName'];
  $email_input = $_POST['user_email'];
  $pass_input = $_POST['password'];

  $_SESSION['user_temp'] = $user_input;
  $_SESSION['first_temp'] = $fname_input;
  $_SESSION['last_temp'] = $lname_input;
  $_SESSION['email_temp'] = $email_input;
  $_SESSION['pass_temp'] = $pass_input;


  if(preg_match($user_req, $user_input) == '0'){
    $_SESSION['uName_error'] = '1';
  }


  if(preg_match($pass_req, $pass_input) == '0'){
    $_SESSION['pass_error'] = '1';
  }

?>