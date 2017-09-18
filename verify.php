<?php
  session_start();

  $user_req = '^\w{6,}+$';
  $pass_req = '^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+])[a-zA-Z\d][a-zA-Z\d!@#$%^&*()_+]{7,}$';
  $user_input = $_POST['username'];
  $pass_input = $_POST['password'];

  $_SESSION['user_temp'] = $user_input;
  $_SESSION['pass_temp'] = $pass_input;




  if(preg_match($pass_req, $pass_input) == '0'){
    Header: "Location: reg_pass_error.php";
  }

?>