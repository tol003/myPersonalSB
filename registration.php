<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration v2 Soundboard</title>
  <link rel="stylesheet" href="./css/main.css">
  <script src="./js/main.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Lora" rel="stylesheet">
</head>
<body id="reg-body">
  <div class="nav-container">
    <div id="logo"></div>
    <ul>
      <li><a href="./landing.php"><div>Soundboards</div></a>
        <div>
          <ul>
            <li><a href="./landing.php">Public</a></li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
  <div id="reg-container">
    <form id="reg-form" action="./verify.php" method="post">
      <div id="reg-heading"><h4>Please fill in the form to register.</h4></div>
      <hr>
      <label class="reg-field" id="ruser">
        <?php
          if(isset($_SESSION['from_verify'])){

            echo '<input id="uName" type="text" name="username" placeholder=" Username" value="'. $_SESSION['user_temp'] .'">
                  <p>Username can be between 4-30 characters long</p>';

            if($_SESSION['user_error'] == '1'){
              unset($_SESSION['user_error']);
              echo '<p class="reg-err-msg">* Please make sure username meets the criteria stated above</p>';
            }
          }

          else{
            echo '<input id="uName" type="text" name="username" placeholder=" Username" value="">
                  <p>Username can be between 4-30 characters long</p>';
          }
        ?>
      </label>
      <label class="reg-field" id="rpass">
        <input id="pWord" type="password" name="password" placeholder=" Password" value="">
        <p>Password must have at least one upper case, one lower case, one number, and one special character</p>
        <?php
          if($_SESSION['pass_error'] == '1' && isset($_SESSION['from_verify'])){
            unset($_SESSION['pass_error']);
            echo '<p class="reg-err-msg">* Please make sure password meets the criteria stated above</p>';
          }
        ?>
      </label>
      <label class="reg-field" id="rfirst">
        <?php
          if(isset($_SESSION['from_verify'])){

            echo '<input id="fName" type="text" name="firstName" placeholder=" First Name" value="'. $_SESSION['first_temp'] .'">';

            if($_SESSION['first_error'] == '1'){
              unset($_SESSION['first_error']);
              echo '<p class="reg-err-msg">* First name cannot be empty</p>';
            }
          }

          else{
            echo '<input id="fName" type="text" name="firstName" placeholder=" First Name" value="">';
          }
        ?>
      </label>
      <label class="reg-field" id="rlast">
        <?php
          if(isset($_SESSION['from_verify'])){

            echo '<input id="lName" type="text" name="lastName" placeholder=" Last Name" value="'. $_SESSION['last_temp'] .'">';

            if($_SESSION['last_error'] == '1'){
              unset($_SESSION['last_error']);
              echo '<p class="reg-err-msg">* Last name cannot be empty</p>';
            }
          }

          else{
            echo '<input id="lName" type="text" name="lastName" placeholder=" Last Name" value="">';
          }
        ?>
      </label>
      <label class="reg-field" id="remail">

        <?php
          if(isset($_SESSION['from_verify'])){

            echo '<input id="uEmail" type="text" name="user_email" placeholder=" Email" value="'. $_SESSION['email_temp'] .'">';

            if($_SESSION['email_error'] == '1'){
              unset($_SESSION['email_error']);
              echo '<p class="reg-err-msg">* Please make sure the email provided is valid</p>';
            }

            else if($_SESSION['email_exist_error'] == '1'){
              unset($_SESSION['email_exist_error']);
              echo '<p class="reg-err-msg">* The email provided already exist</p>';
            }
          }

          else{
            echo '<input id="uEmail" type="text" name="user_email" placeholder=" Email" value="">';
          }
        ?>
      </label>
      <input id="regBtn" type="submit" name="registerBtn" value="Register">
    </form>
    <form id="reg-logForm" action="./login.php" method="get">
      <p id="reg-log-p">Already have an account?</p>
      <input id="reg-logBtn" type="submit" value="Login">
    </form>
    <?php
      unset($_SESSION['from_verify']);
    ?>
  </div>
</body>
</html>