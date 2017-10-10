<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>v2.1 Soundboard</title>
  <?php
    include('header.php');
  ?>
</head>
<body>
  <div class="nav-container">
    <ul>
      <li><a href="./landing.php"><div>Soundboards</div></a>
        <div>
          <ul>
            <li><a href="./landing.php">Public</a></li>
            <?php if(isset($_SESSION['email'])): ?>
              <li><a href="./private_SB.php">Private</a></li>
            <?php endif; ?>
          </ul>
        </div>
      </li>
      <?php if(isset($_SESSION['email'])): ?>
        <li><a href="./logout.php"><div>Log Out</div></a>
        </li>
      <?php endif; ?>
      <?php if ($_SESSION['admin']=='1'): ?>
        <li><a href="./admin_page.php"><div>Admin</div></a>
        </li>
      <?php endif ?>
    </ul>
    <?php
      if(isset($_SESSION['email'])){
        echo '<p class="login" id="hello">Hello, '. $_SESSION['first_name'] .'</p>';
      }

      else{
        echo '<form id="register" action="./registration.php" method="get">
          <input type="submit" value="Register">
        </form>
        <form id="login" action="./login.php" method="get">
          <input type="submit" value="Sign in">
        </form>';
      }
    ?>
  </div>
<?php

if($_SESSION['email'] ){
require_once("connection.php");
  if($_SERVER["REQUEST_METHOD"] == 'GET'){
  $sound_err = $_REQUEST["sound_err"];
  $img_err = $_REQUEST["img_err"];
   
  $sid = isset($_GET["sid"])   ?  $_GET["sid"] :  $_REQUEST["sid"];
  $sbid = isset($_GET["sbid"]) ?  $_GET["sbid"] :  $_REQUEST["sbid"];

echo '
  <form action="soundupdate.php" method="post" enctype="multipart/form-data">
  <select id ="myselect" onchange="myFunction()" name="choice">
  <option value="img_sound">Update: image and sound</option>
  <option value="sound">Update: sound </option>
  <option value="image">Update: image </option>
  </select><br>

   <p id ="psound"> Select sound to upload:</p>
    <input type="file" name="soundToUpload" id="soundToUpload"><br>
    <p id="pimg">Select image to upload:</p>
    <input type="file" name="imageToUpload" id="imageToUpload" ><br>
    <input type="hidden" name="sid" value="'.$sid.'" > 
    <input type="hidden" name="sbid" value="'.$sbid.'" > 
    <input type="submit" value="Upload" name="submit">
    
  </form>
  <p style="color:red" >'.$img_err.' </p> <br>
  <p style="color:red" >'.$sound_err.' </p> <br>
  <script>
  function myFunction() {
        var x = document.getElementById("myselect").value;
        if( x == "sound"){
            document.getElementById("imageToUpload").style.visibility = "hidden";
            document.getElementById("soundToUpload").style.visibility = "visible";
            document.getElementById("psound").style.visibility = "visible";
            document.getElementById("pimg").style.visibility = "hidden";
        }
        if( x == "image"){
            document.getElementById("soundToUpload").style.visibility = "hidden";
            document.getElementById("psound").style.visibility = "hidden";
            document.getElementById("pimg").style.visibility = "visible";
            document.getElementById("imageToUpload").style.visibility = "visible";
        }
        if( x == "img_sound"){
            document.getElementById("soundToUpload").style.visibility = "visible";
            document.getElementById("imageToUpload").style.visibility = "visible";
            document.getElementById("psound").style.visibility = "visible";
            document.getElementById("pimg").style.visibility = "visible";
        }

  }
  </script>';
}
elseif($_SERVER["REQUEST_METHOD"] == "POST"){
   $sound_err = "";
   $img_err = "";
   $images_dir = "images/".$_SESSION['user_id']."/";
   $sounds_dir = "sounds/".$_SESSION['user_id']."/";

   if (!file_exists($sb_image_dir)) {
        mkdir($images_dir, 0777, true);
   }
   if (!file_exists($sound_dir)) {
      mkdir($sounds_dir, 0777, true);
   }
    $uploadOk = 1;
    $sound_file = $sounds_dir . basename($_FILES["soundToUpload"]["name"]);
    $image_file = $images_dir . basename($_FILES["imageToUpload"]["name"]);
    $uploadOk_sd = 1;
    $imageFileType = pathinfo($image_file,PATHINFO_EXTENSION);
    $soundFileType = pathinfo($sound_file,PATHINFO_EXTENSION);
    $types =  $_FILES['soundToUpload']['tmp_name'];
    $mime = mime_content_type($types);
    
    if($soundFileType == "mp3" || $soundFileType == "wav" || 
                $soundFileType == "AIFF"  || $soundFileType == "FLAC" ) {
    if($mime == "audio/mpegFile" || $mime == "audio/mp4" || $mime ==
                    "audio/vnd.wav" || $mime == "audio/x-aiff"|| $mime == "audio/mpeg"){ 
                echo "<p>File is an sound - ".$_FILES["soundToUpload"]["type"]. "</p><br>";
    }else{
                  $sound_err ="file does not seem to be a sound file ".
                    $types." mime is ".$mime;
                  $uploadOk_sd = 0;
    }
  }

   if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType ==
       "gif"|| $imageFileType == "jpeg"){
                            
    $typei =  $_FILES['imageToUpload']['tmp_name'];
          $mime = mime_content_type($typei);
          if( $mime == "image/jpeg" || $mime == "image/gif"){
                   $_err ="file seem to be an image file";
          }else{
  
      $img_err ="file does not seem to be a image file ".$typei." mime s is
        ".$mime;
      $uploadOk = 0;

  }

   }
          
   if($_POST["choice"] == "img_sound"){
      
        /*  $sound_file = $sound_dir . basename($_FILES["soundToUpload"]["name"]);
          $image_file = $sb_image_dir . basename($_FILES["imageToUpload"]["name"]);
         $imageFileType = pathinfo($image_file,PATHINFO_EXTENSION);
          $soundFileType = pathinfo($sound_file,PATHINFO_EXTENSION);
          // Check if image file is a actual image or fake image */
            if(!file_exists($_FILES['soundToUpload']['tmp_name']) || 
                  !is_uploaded_file($_FILES['soundToUpload']['tmp_name'])){
                  
                  echo "Sorry, unable to upload sound. The file might be too large; ";
                  $sound_err = "Sorry, unable to upload sound. The file might be too large; ";
                  $uploadOk_sd = 0;
              }
              if(!file_exists($_FILES['imageToUpload']['tmp_name']) || 
                  !is_uploaded_file($_FILES['imageToUpload']['tmp_name'])){
                  echo  "Sorry, unable to upload image. The file might be too large";
                  $img_err = "Sorry, unable to upload image. The file might be too large;";
                  $uploadOk = 0;
              }

          if(isset($_POST["submit"])) {
              $check_img = getimagesize($_FILES["imageToUpload"]["tmp_name"]);
              //$check_sound = getimagesize($_FILES["soundToUpload"]["tmp_name"]);
              if($check_img !== false) {
                echo "File is an image - " . $check_img["mime"] . ".";
              }else {
                echo "File is not an image.";
                $uploadOk = 0;
              }
          }
        //   Allow certain file formats
          if( $imageFileType != "jpg" && $imageFileType != "png" && 
                $imageFileType !="jpeg"  && $imageFileType != "gif") {
                
              echo "<p>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</p>";
                $img_err ="Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
          }
        //   Allow certain file formats
          if( $soundFileType != "mp3" && $soundFileType != "wav" && 
                $soundFileType != "AIFF"  && $soundFileType != "FLAC" ) {
                echo "<p>Sorry, only mp3, wav, AIFF & FLAC files are allowed.</p>";
              $sound_err = "Sorry, only mp3, wav, AIFF & FLAC files are allowed.";
              $uploadOk_sd = 0;
          }
            if((int) $_SERVER['CONTENT_LENGTH'] > 2000000 ){
              echo "<p>choose a smaller sound file</p>"; 
              $uploadOk_sd = 0;
              $sound_err = "files are too larger, choose smaller files";
            }  

          if($uploadOk == 0 || $uploadOk_sd == 0){
              Header("Location: soundupdate.php?sound_err=".$sound_err."&img_err=".$img_err."&sid=".$_POST["sid"]."&sbid=".$_POST["sbid"]);
          }
          else{
            
            move_uploaded_file($_FILES['imageToUpload']['tmp_name'], $image_file); 
            move_uploaded_file($_FILES['soundToUpload']['tmp_name'], $sound_file); 
            $db = new Db();
            $sbid= $_POST['sbid'];
            $sid= $_POST['sid'];
            
            $db -> userUpdateSoundFull($sid, $image_file,$sound_file);

            if(file_exists($image_file)){
                echo 'File '.$_FILES['imageToUpload']['name'].' uploaded successfully.';
            }
            else{
              Header("Location: index.php");
            }
            if(file_exists($sound_file)){
                echo 'File '.$_FILES['soundToUpload']['name'].' uploaded successfully.';
            }
            else{
                Header("Location: landing.php");
            }

            Header("Location: private_sounds.php?sbid=".$sbid);
          }
     }
     if($_POST["choice"] == "sound") {

        // $sound_file = $sound_dir . basename($_FILES["soundToUpload"]["name"]);
          //$soundFileType = pathinfo($sound_file,PATHINFO_EXTENSION);
          // Check if image file is a actual image or fake image
            if(!file_exists($_FILES['soundToUpload']['tmp_name']) || 
                  !is_uploaded_file($_FILES['soundToUpload']['tmp_name'])){
                  
                  echo "Sorry, unable to upload sound. The file might be too large; ";
                  $sound_err = "Sorry, unable to upload sound. The file might be too large; ";
                  $uploadOk_sd = 0;
              }
                     
        //   Allow certain file formats
          if($soundFileType != "mp3" && $soundFileType != "wav" && 
                $soundFileType != "AIFF"  && $soundFileType != "FLAC" ) {
                echo "<p>Sorry, only mp3, wav, AIFF & FLAC files are allowed.</p>";
              $sound_err = "Sorry, only mp3, wav, AIFF & FLAC files are allowed.";
              $uploadOk_sd = 0;
          }
            if((int) $_SERVER['CONTENT_LENGTH'] > 2000000 ){
              $uploadOk_sd = 0;
              $sound_err = "files are too larger, choose smaller files";
              echo "<p>choose a smaller sound file</p>"; 
            }  

          if($uploadOk_sd == 0){
             Header("Location: soundupdate.php?img_err=".$sound_err."&sid=".$_POST["sid"]."&sbid=".$_POST["sbid"]);
          }
          else{
            
            move_uploaded_file($_FILES['soundToUpload']['tmp_name'], $sound_file); 
            $db = new Db();
            $sbid= $_POST['sbid'];
            $sid= $_POST['sid'];
            
            $db -> userUpdateSound($sid, $sound_file);
            
            if(file_exists($sound_file)){
                echo 'File '.$_FILES['soundToUpload']['name'].' uploaded successfully.';
            }
            else{
                Header("Location: index.php"); 
            }

            Header("Location: private_sounds.php?sbid=".$sbid);
          }
     }

    if($_POST["choice"] == "image"){
    
          $image_file = $sb_image_dir . basename($_FILES["imageToUpload"]["name"]);
          $imageFileType = pathinfo($image_file,PATHINFO_EXTENSION);

              if(!file_exists($_FILES['imageToUpload']['tmp_name']) || 
                  !is_uploaded_file($_FILES['imageToUpload']['tmp_name'])){
                  echo  "Sorry, unable to upload image. The file might be too large";
                  $img_err = "Sorry, unable to upload image. The file might be too large;";
                  $uploadOk = 0;
              }

          
          if(isset($_POST["submit"])) {
              $check_img = getimagesize($_FILES["imageToUpload"]["tmp_name"]);
              //$check_sound = getimagesize($_FILES["soundToUpload"]["tmp_name"]);
              if($check_img !== false) {
                echo "File is an image - " . $check_img["mime"] .$mime;
              }else {
                echo "File is not an image.";
                $img_err = "file not recognized as image ";
                $uploadOk = 0;
              }
                        
          }
          
        //   Allow certain file formats
          if(  $imageFileType != "jpg" && $imageFileType != "png" && 
                $imageFileType !="jpeg"  && $imageFileType != "gif" ) {
                
              echo "<p>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</p>";
                $img_err ="Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
          }
        
            if((int) $_SERVER['CONTENT_LENGTH'] > 2000000 ){
              echo "<p>choose a smaller sound file</p>"; 
                $img_err ="file too large, uplaoad a smaller image";
                $uploadOk = 0;
           }  
            
          if($uploadOk == 0 ){
             Header("Location: soundupdate.php?img_err=".$img_err."&sid=".$_POST["sid"]."&sbid=".$_POST["sbid"]);
          }
          else{
            
            move_uploaded_file($_FILES['imageToUpload']['tmp_name'], $image_file); 
            $db = new Db();
            $sbid= $_POST['sbid'];
            $sid= $_POST['sid'];
            
            $db -> userUpdateImage($sid, $image_file);

            if(file_exists($image_file)){
                echo 'File '.$_FILES['imageToUpload']['name'].' uploaded successfully.';
            }
            else{
              Header("Location: landing.php");
            }
            
            Header("Location: private_sounds.php?sbid=".$sbid);
          }         

    }

}
}else{

    Header("Location: landing.php");

}
?>
</body>
</html>
