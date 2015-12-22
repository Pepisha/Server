<?php

require_once 'models/User.php';
require_once 'models/Shelter.php';

class Message {

    private $idMessage;
    private $content;
    private $dateMessage;
    private $idUser;
    private $idShelter;

    public function __construct($idMessage) {
      $db = DbManager::getPDO();
      $query = "SELECT * FROM Message WHERE idMessage = ".$idMessage."";
      $res = $db->query($query)->fetch();

      $this->idMessage = $res['idMessage'];
      $this->content = $res['content'];
      $this->dateMessage = $res['dateMessage'];
      $this->idUser = $res['idUser'];
      $this->idShelter = $res['idShelter'];
    }

    public static function addMessageInDataBase($content, $idUser, $idShelter) {
      if (!User::isUserExistInDataBase($idUser)) {
        return "Unknown user";
      }
      elseif (!Shelter::isShelterExistInDataBase($idShelter)) {
        return "Unknown shelter";
      }
      else {
        $db = DbManager::getPDO();
        $query = "INSERT INTO Message(content, dateMessage, idUser, idShelter) "
                ."VALUES ('".$content."',NOW(),".$idUser.",".$idShelter.")";
        return ($db->exec($query) >= 0);
      }
    }
}
