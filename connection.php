<?php
  if(!class_exists('Db')){
    class Db{
      // database connection
      protected $conn;
     
      protected $db_name;
      protected $db_user;
      protected $db_pass;
      protected $db_host;

      /*connection to database
       *
       * return false on failure and a mysqli Object on success
       */
      public function __construct() {
        $config = parse_ini_file('../../config.ini');
        $this ->db_host = $config['host'];
        $this ->db_user = $config['username'];
        $this ->db_pass = $config['password'];
        $this ->db_name = $config['dbname'];
      }

      protected function connect(){
        if(!isset($this->conn)){
          $this->conn = new mysqli($this->db_host, $this->db_user, $this->db_pass,
              $this->db_name);
        }

        if ($this->conn -> connect_error) {
          die('Connect Error (' .$this->conn->connect_errno . ') '.
               $this->conn->connect_error);
        }

        return $this -> conn;
      }

      public function escapeStr($value) {
        $connection = $this -> connect();
        return "'" . $connection -> real_escape_string($value) . "'";
      }

      /***********************************************************************
       *              mySQL function calls for soundboard data               *
       ***********************************************************************/

      public function getPublicSB(){

        $db = $this ->connect();

        $query = "
            SELECT
            board_id,
            board_name
          from
            soundboards
          where
            public = 1";

        return $result = $db->query($query);
      }

      public function userGetSB($userID){

        $idInt = intVal($userID);

        $db = $this->connect();

        $query = "
          SELECT
            soundboards.board_id,
            board_name
          FROM
            users, has_boards, soundboards
          WHERE
            ". $idInt ." = users.user_id
          AND
            users.user_id = has_boards.user_id
          AND
            has_boards.board_id = soundboards.board_id";

        return $result = $db->query($query);
      }

      public function userCreateSB($userId, $boardName, $public){

        $userInt = intval($userId);
        $nameEsc = $this->escapeStr($boardName);
        $publicInt = intval($public);

        $db = $this->connect();


        return $result = $db->query("CALL createSB(".$userInt.",".
            $nameEsc.",".$publicInt.")");
      }

      public function userUpdateSB($boardID, $boardName){

        $idEsc = intVal($boardID);
        $nameEsc = $this->escapeStr($boardName);

        $db = $this->connect();

        $query = "
          UPDATE
            soundboards
          SET
            board_name = ". $nameEsc ."
          where
            board_id = ". $idEsc;

        return $result = $db->query($query);
      }

      public function userDeleteSB($userID, $boardID){

        $userInt = intval($userID);
        $boardInt = intval($boardID);

        $db = $this->connect();

        return $result = $db->query("CALL deleteSB(". $userInt .",". $boardInt .")");
      }

      public function adminDeleteSB($sbID){

        $idInt = intval($sbID);

        $db = $this->connect();

        return $result = $db->query("CALL adminDeleteSB(". $idInt .")");
      }

      /***********************************************************************
       *                 mySQL function calls for sounds data                *
       ***********************************************************************/

      public function userGetSound($sbID){

        $idInt = intval($sbID);

        $db = $this->connect();

        $query = "
          SELECT
            sounds.sound_id,
            sound_path,
            img_path
          FROM
            soundboards, has_sounds, sounds
          WHERE
            ". $idInt ." = soundboards.board_id
          AND
            soundboards.board_id = has_sounds.board_id
          AND
            has_sounds.sound_id = sounds.sound_id";

          return $result = $db->query($query);
      }

      public function createSound($boardID, $sound, $image){

        $boardInt = intval($boardID);
        $soundEsc = $this->escapeStr($sound);
        $imageEsc = $this->escapeStr($image);

        $db = $this->connect();

        return $result = $db->query("CALL createSounds(". $boardInt .",". $soundEsc .",". $imageEsc .")");
      }

      public function userUpdateSound($soundID, $soundFile){

        $idEsc = intVal($soundID);
        $fileEsc = $this->escapeStr($soundFile);

        $db = $this->connect();

        $query = "
          UPDATE
            sounds
          SET
            sound_path = ". $fileEsc .
            "WHERE
            sound_id = ". $idEsc;

        return $result = $db->query($query);
      }

      public function userUpdateImage($soundID, $imageFile){

        $idEsc = intval($soundID);
        $fileEsc = $this->escapeStr($imageFile);

        $db = $this->connect();

        $query = "
          UPDATE
            sounds
          SET
            img_path = ". $fileEsc."
          WHERE
            sound_id = ". $idEsc;

        return $result = $db->query($query);

      }

      public function userUpdateSoundFull($soundID, $imageFile, $soundFile){

        $idEsc = intval($soundID);
        $fileEsc = $this->escapeStr($imageFile);
        $soundEsc = $this->escapeStr($soundFile);

        $db = $this->connect();

        $query ="
          UPDATE
            sounds
          SET
            sound_path =" . $soundEsc.",img_path =". $fileEsc."
          WHERE
            sound_id = ". $idEsc;

        return $result = $db->query($query);
      }

      public function userDeleteSound($soundID){

        $soundInt = intval($soundID);

        $db = $this->connect();

        return $result = $db->query("CALL deleteSound(". $soundInt .")");
      }

      /***********************************************************************
       *              mySQL function calls for user data                     *
       ***********************************************************************/
    }
  }
?>
