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
if(isset($_SESSION['email'])){
  require_once("connection.php");
    if($_SERVER["REQUEST_METHOD"] == 'GET'){
    $sound_err = $_REQUEST["sound_err"];

    $img_err = $_REQUEST["img_err"];
    $sbid = isset($_GET["sbid"])   ?  $_GET["sbid"] :  $_REQUEST["sbid"];
  echo '
    <form action="soundupload.php" method="post" enctype="multipart/form-data">
      Select sound to upload:
      <input type="file" name="soundToUpload" id="soundToUpload"required ><br>
      Select image to upload:
      <input type="file" name="imageToUpload" id="imageToUpload" required><br>
      <input type="hidden" name="sbid" value="'.$sbid.'" >
      <input type="submit" value="Upload" name="submit">

    </form>
    <p style="color:red" >'.$img_err.' </p> <br>
    <p style="color:red" >'.$sound_err.' </p> <br>';
  
}

elseif($_SERVER["REQUEST_METHOD"] == "POST"){
   $sound_err = "";
   $img_err = "";
   $images_dir = "./images/".$_SESSION['user_id']."/";
   $sounds_dir = "./sounds/".$_SESSION['user_id']."/";

   if (!file_exists($images_dir)) {
        mkdir($images_dir, 0777, true);
   }
   if (!file_exists($sounds_dir)) {
      mkdir($sounds_dir, 0777, true);
   }



   $sound_file = $sounds_dir . basename($_FILES["soundToUpload"]["name"]);
   $image_file = $images_dir . basename($_FILES["imageToUpload"]["name"]);
   $uploadOk = 1;
   $uploadOk_sd = 1;
   $imageFileType = pathinfo($image_file,PATHINFO_EXTENSION);
   $soundFileType = pathinfo($sound_file,PATHINFO_EXTENSION);
   // Check if image file is a actual image or fake image


/*
    $mime = mime_content_type($_FILES['soundToUpload']['tmp_name']);
    
    if($soundFileType == "mp3" || $soundFileType == "wav" || 
                $soundFileType == "AIFF"  || $soundFileType == "FLAC" ) {
    if($mime == "audio/mpegFile" || $mime == "audio/mp4" || $mime ==
                    "audio/vnd.wav" || $mime == "audio/x-aiff"){ 
                echo "<p>File is an sound - ".$_FILES["soundToUpload"]["type"]. "</p><br>";
    }else{
                  $sound_err ="file does not seem to be a sound file";
                  $uploadOk_sd = 0;
    }
  

   if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType ==
       "gif"|| $imageFileType == "jpeg"){
                            
          $mime = mime_content_type($_FILES['soundToUpload']['tmp_name']);
          if( $mime == "image/jpeg" || $mime == "image/gif"){
              $The = "this should work";
          }else{
  
      $img_err ="file does not seem to be a image file";
      $uploadOk = 0;

  }

   }
*/


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
          if( $mime == "image/jpeg" || $mime == "image/gif"|| $mime ==
              "image/png"){
                   $_err ="file seem to be an image file";
          }else{
  
      $img_err ="file does not seem to be a image file ".$typei." mime s is ".$mime;
      $uploadOk = 0;

  }

   }

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
   if(  $imageFileType != "jpg" && $imageFileType != "png" && 
         $imageFileType !="jpeg"  && $imageFileType != "gif") {
        
       echo "<p>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</p>";
        $img_err ="Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
   }
//   Allow certain file formats
   if(($_FILES["soundToUpload"]["type"] == "audio/mpeg"||
         $_FILES["soundToUpload"]["type"] == "audio/wma") &&
        ($soundFileType != "mp3" && $soundFileType != "wav" && 
         $soundFileType != "AIFF"  && $soundFileType != "FLAC" )) {
        echo "<p>Sorry, only mp3, wav, AIFF & FLAC files are allowed.</p>";
      $sound_err = "Sorry, only mp3, wav, AIFF & FLAC files are allowed.";
      $uploadOk_sd = 0;
   }
   else{
   
   }
    if((int) $_SERVER['CONTENT_LENGTH'] > 2000000 ){
      echo "<p>choose a smaller sound file</p>"; 
      $sound_err = "sound files are too large, please upload less 2MB";
      $uploadOk = 0;
    }  


   if($uploadOk == 0 || $uploadOk_sd == 0){
      Header("Location: soundupload.php?sound_err=".$sound_err."&img_err=".$img_err);
   }
   
   else{
     
     move_uploaded_file($_FILES['imageToUpload']['tmp_name'], $image_file); 
     move_uploaded_file($_FILES['soundToUpload']['tmp_name'], $sound_file); 
     $db = new Db();
     $sbid= $_POST['sbid'];
     
    $db -> createSound($sbid, $sound_file, $image_file);

     if(file_exists($image_file)){
        echo 'File '.$_FILES['imageToUpload']['name'].' uploaded successfully.';
     }
     else{
      Header("Location: nzechiTest.php");
     }
     if(file_exists($sound_file)){
        echo 'File '.$_FILES['soundToUpload']['name'].' uploaded successfully.';
     }
     else{
         Header("Location: nzechiTest.php"); 
     }

     Header("Location: private_sounds.php?sbid=".$sbid);
   }
      Header("Location: soundupload.php?sound_err=".$sound_err."&img_err=".$img_err);
}
}else{

      Header("Location: landing.php");

}
?>
</body>
</html>
