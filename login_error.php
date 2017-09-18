<?php
  session_start();
  $_SESSION['fromLogin'] = '1';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome To Tonberry's Kitchen</title>
    <link rel="stylesheet" href="./css/main.css">
    <script src="./js/main.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Lora" rel="stylesheet">
</head>
<body id="login-body">
    <div id="login-container">
        <form id="login-form" action="./verify.php" method="post">
            <div><h4>Please sign in to continue.</h4></div>
            <hr>
            <label id="email">
                <input id="uEmail" type="text" name="user_email" placeholder=" Email" value="">
            </label>
            <label id="pass">
                <input id="pWord" type="password" name="password" placeholder=" Password" value="">
            </label>
            <input id="logBtn" type="submit" name="loginBtn" value="Login">
        </form>
        <form id="reg-form" action="./registration.php" method="get">
          <p id="reg-p">Don't have an account yet?</p>
          <input id="regBtn" type="submit" name="registerBtn" value="Register">
        </form>
        <p id="err-msg">*Sorry, there was an error with the username or password while logging in. Please try again.*</p>
    </div>
</body>
</html>