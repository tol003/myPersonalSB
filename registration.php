<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login v2 Soundboard</title>
  <link rel="stylesheet" href="./css/main.css">
  <script src="./js/main.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Lora" rel="stylesheet">
</head>
<body id="reg-body">
  <div id="reg-container">
    <form id="reg-form" action="./verify.php" method="post">
      <div><h4>Please fill in the form to register.</h4></div>
      <hr>
      <label class="reg-field" id="ruser">
        <input id="uName" type="text" name="userName" placeholder=" Username" value="">
        <p>Username can be between 4-30 characters long</p>
      </label>
      <label class="reg-field" id="rpass">
        <input id="pWord" type="password" name="password" placeholder=" Password" value="">
        <p>Password must have at least one upper case, one lower case, one number, and one special character</p>
      </label>
      <label class="reg-field" id="rfirst">
        <input id="fName" type="text" name="firstName" placeholder=" First Name" value="">
      </label>
      <label class="reg-field" id="rlast">
        <input id="lName" type="text" name="lastName" placeholder=" Last Name" value="">
      </label>
      <label class="reg-field" id="remail">
        <input id="uEmail" type="text" name="user_email" placeholder=" Email" value="">
      </label>
      <input id="regBtn" type="submit" name="registerBtn" value="Register">
    </form>
    <form id="reg-logForm" action="./login.php" method="get">
      <p id="reg-log-p">Already have an account?</p>
      <input id="reg-logBtn" type="submit" value="Login">
    </form>
    <?php

    ?>
  </div>
</body>
</html>