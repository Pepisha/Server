<?php

require_once 'models/User.php';
require_once 'models/Shelter.php';

class Message {

    private $idMessage;
    private $content;
    private $dateMessage;
    private $idUser;
    private $idShelter;
    private $idAnimal;
    private $read;

    public function __construct($idMessage) {
      $db = DbManager::getPDO();
      $query = "SELECT * FROM Message WHERE idMessage = ".$idMessage."";
      $res = $db->query($query)->fetch();

      $this->idMessage = $res['idMessage'];
      $this->content = $res['content'];
      $this->dateMessage = $res['dateMessage'];
      $this->idUser = $res['idUser'];
      $this->idShelter = $res['idShelter'];
      $this->idAnimal = $res['idAnimal'];
      $this->read = $res['read'];
    }

    public static function addMessageInDataBase($content, $idUser, $idShelter, $idAnimal = null) {
      if (!User::isUserExistInDataBase($idUser)) {
        return "Unknown user";
      }
      elseif (!Shelter::isShelterExistInDataBase($idShelter)) {
        return "Unknown shelter";
      }
      else {
        $db = DbManager::getPDO();
        $query = "INSERT INTO Message(content, dateMessage, idUser, idShelter, idAnimal) "
                ."VALUES ('".$content."',NOW(),".$idUser.",".$idShelter.",".$idAnimal.")";
        return ($db->exec($query) >= 0);
      }
    }

    public static function getMessageArrayFromFetch($message) {
      $messageArray["idMessage"] = intval($message["idMessage"]);
      $messageArray["content"] = $message['content'];
      $messageArray["dateMessage"] = $message['dateMessage'];
      $messageArray["idUser"] = intval($message['idUser']);
      $messageArray["idShelter"] = intval($message['idShelter']);
      $messageArray["idAnimal"] = intval($message['idAnimal']);
      $messageArray["read"] = boolval($message['read']);
      return $messageArray;
    }
}
