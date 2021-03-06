<?php
  session_start();

  require_once("connection.php");



  function createLanding(){

    $db = new Db();

    $result = ($db->getPublicSB());

    if(mysqli_num_rows($result) > 0){

      while($row = mysqli_fetch_assoc($result)){

        $str .= '<tr class="sb-box">
                     <td class="image-column">
                       <form class="sb-form" action="./sounds.php" method="get">';

          $img_result = ($db->userGetSound($row['board_id']));

          if(mysqli_num_rows($img_result) > 0){

            $img_row = mysqli_fetch_assoc($img_result);

            $str .= '<img class="sb-main-image" src="'. $img_row['img_path'] .'">';
          }

          else{
            $str .= '<img class="sb-main-image" src="./site_images/default_image.jpg">';
          }

          $str .= '<input class="sb-image-btn" type="submit" value="">
                     <input class="hide" type="hidden" name="sbid" value="'. $row['board_id'] .'">
                          </form>
                        </td>
                        <td class="title-column">
                            <p class="pub-title">'. $row['board_name'] .'</p>
                        </td>
                      </tr>';
      }

      echo $str;
    }

    else{
      echo '<h2>There are no public Sound Boards</h2>';
    }
  }

  function getSB($userID){

    $db = new Db();

    $result = ($db->userGetSB($userID));

    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)){

         $str .= '<tr class="sb-box">
                     <td class="image-column">
                       <form class="sb-form" action="./private_sounds.php" method="get">';

          $img_result = ($db->userGetSound($row['board_id']));

          if(mysqli_num_rows($img_result) > 0){

            $img_row = mysqli_fetch_assoc($img_result);

            $str .= '<img class="sb-main-image" src="'. $img_row['img_path'] .'">';
          }

          else{
            $str .= '<img class="sb-main-image" src="./site_images/default_image.jpg">';
          }

          $str .= '<input class="sb-image-btn" type="submit" value="">
                     <input class="hide" type="hidden" name="sbid" value="'. $row['board_id'] .'">
                          </form>
                        </td>
                        <td>
                          <form class="title-form" action="./sb_update_confirm.php" method="post" onsubmit="return updateSBConfirm('. $row['board_id'] .')">
                            <input id="'. $row['board_id'] .'" name="sb-title"
                            class="title-field" type="text" value="'. $row['board_name'] .'">
                            <input class="cancel-btn" type="button" value="">
                            <input class="confirm-btn" type="submit" value="">
                            <input type="hidden" name="sbid" value="'. $row['board_id'] .'">
                          </form>
                        </td>
                        <td>
                          <form class="trash-container" action="./sb_delete_confirm.php" method="post" onsubmit="return deleteSBConfirm('. $row['board_id'] .')">
                            <input class="trash" type="submit" value="">
                            <input type="hidden" name="sbid" value="'. $row['board_id'] .'">
                            <input type="hidden" name="sb-title" value="'. $row['board_name'] .'">
                          </form>
                        </td>
                  </tr>';

      }
    }

    $str .= '<form style="text-align:center" action="./private_SB.php" method="POST">
               <input type="text" name="sb_name" placeholder="Name" required>
               <br>
               <select name="status">
               <option value="0"> private </option>
               <option value="1"> public </option>
               </select> <br>
               <input title="Add SoundBoard" type="image" src="./site_images/addbtn.png">
             </form>';

    echo $str;
  }


/************************* Get Sounds Functions ***************************/


  function getSounds($sbID){

    $db = new Db();

    $result = ($db->userGetSound($sbID));

    if(mysqli_num_rows($result) > 0){

      while($row = mysqli_fetch_assoc($result)){
        $str .= '<div class="button-wrapper" id="'. $row['sound_id'] .'" onclick="playMusic(this.id)">
                 <audio src="'. $row['sound_path'] .'" preload="auto"></audio>
                 <div class="button-overlay"></div>
                 <img class="image-sound" src="'. $row['img_path'] .'">
                 </div>';
      }
    }

    echo $str;
  }

  function getPrivateSounds($sbID){

    $db = new Db();

    $result = ($db->userGetSound($sbID));

    if(mysqli_num_rows($result) > 0){

      while($row = mysqli_fetch_assoc($result)){
        $str .= '<div sounds-wrapper>
                   <div class="button-wrapper" id="'. $row['sound_id'] .'" onclick="playMusic(this.id)">
                     <audio src="'. $row['sound_path'] .'" preload="auto"></audio>
                     <div class="button-overlay"></div>
                     <img class="image-sound" src="'. $row['img_path'] .'">
                   </div>
                   <form id="'. $row['sound_id'] .'" class="sound-button-del" action="./sound_delete_confirm.php" method="post"
                   onsubmit="return deleteSoundConfirm('. $row['sound_id'] .','. $sbID .')">
                   <input class="sound-delete" type="submit" value="">
                   <input type="hidden" name="sound_id" value="'. $row['sound_id'] .'">
                   <input type="hidden" name="sound_path" value="'. $row['sound_path'] .'">
                   <input type="hidden" name="sbid" value="'. $sbID .'">

                   </form>
                   <form class="sound-button-edit" action="./soundupdate.php" method="get">
                   <input class="sound-edit" type="submit" value="">
                   <input type="hidden" name="sid" value="'. $row['sound_id'] .'">
                   <input type="hidden" name="sbid" value="'. $sbID .'">
                   </form>
                 </div>';
      }
    }

    echo $str;
  }

/************************* Get User Functions ***************************/

  function getUserInfo($email, $password){

    $db = new Db();

    $result = ($db->userLogin($email, $password));

    if(mysqli_num_rows($result) > 0){

      $row = mysqli_fetch_assoc($result);

      $_SESSION['user_id'] = $row['user_id'];
      $_SESSION['username'] = $row['username'];
      $_SESSION['first_name'] = $row['first_name'];
      $_SESSION['last_name'] = $row['last_name'];
      $_SESSION['email'] = $row['email'];
      $_SESSION['admin'] = $row['admin'];
    }

    else{

      $_SESSION['login_error'] = '1';
      header('Location: login.php');
      die();
    }
  }

  function createUserInfo($username, $password, $firstname, $lastname, $email){

    $db = new Db();

    $result = ($db->userInsert($username, $password, $firstname, $lastname, $email));

    if($result){
      $_SESSION['reg_complete'] = '1';

      unset($_SESSION['user_temp']);
      unset($_SESSION['pass_temp']);
      unset($_SESSION['first_temp']);
      unset($_SESSION['last_temp']);
      unset($_SESSION['email_temp']);

      header('Location: login.php');
    }

    else{
      echo '<script>console.log("There was an error during the mysql insert")</script>';
    }
  }

  function checkEmail($email){

    $db = new Db();

    $email_exist = ($db->checkUserEmail($email));

    if(mysqli_num_rows($email_exist) > 0){

      return false;
    }

    return true;
  }

?>
