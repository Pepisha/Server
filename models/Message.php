<?php

require_once 'models/User.php';
require_once 'models/Animal.php';
require_once 'models/Shelter.php';

class Message {

    private $idMessage;
    private $content;
    private $dateMessage;
    private $idUser;
    private $idShelter;
    private $idAnimal;
    private $messageRead;

    public function __construct($idMessage) {
      $db = DbManager::getPDO();
      $query = "SELECT * FROM Message WHERE idMessage = ".$idMessage;
      $res = $db->query($query)->fetch();

      $this->idMessage = $res['idMessage'];
      $this->content = $res['content'];
      $this->dateMessage = $res['dateMessage'];
      $this->idUser = $res['idUser'];
      $this->idShelter = $res['idShelter'];
      $this->idAnimal = $res['idAnimal'];
      $this->messageRead = $res['messageRead'];
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
      $messageArray["nickname"] = User::getNicknameFromId($message['idUser']);
      $messageArray["idShelter"] = intval($message['idShelter']);
      $messageArray["idAnimal"] = intval($message['idAnimal']);
      $messageArray["messageRead"] = boolval($message['messageRead']);

      if (!is_null($message['idAnimal'])) {
        $animal = new Animal($message['idAnimal']);
        $messageArray["animalName"] = $animal->getName();
      }

      return $messageArray;
    }

    public function setRead() {
      $db = DbManager::getPDO();
      $query = "UPDATE Message SET messageRead = 1 WHERE idMessage = ".$this->idMessage;
      $db->exec($query);
    }
}
