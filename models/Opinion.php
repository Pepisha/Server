<?php

require_once 'models/User.php';
require_once 'models/Shelter.php';

class Opinion {
    private $idOpinion;
    private $stars;
    private $description;
    private $idUser;
    private $idShelter;
    
    public function __construct($idOpinion) {
      $db = DbManager::getPDO();
      $query = "SELECT * FROM Opinion WHERE idOpinion = ".$idOpinion."";
      $res = $db->query($query)->fetch();
      $this->idOpinion = $res['idOpinion'];
      $this->stars = $res['stars'];
      $this->description = $res['description'];
      $this->idUser = $res['idUser'];
      $this->idShelter = $res['idShelter'];
    }
    
    public static function isOpinionExistInDataBase($idOpinion) {
        $db = DbManager::getPDO();
        $query = "SELECT idOpinion FROM Opinion WHERE idOpinion = ".$idOpinion."";
        $res = $db->query($query)->fetch();
        return $res['idOpinion'] === $idOpinion;
    }
    
    public static function addOpinionInDataBase($stars, $description, $idUser, $idShelter) {
        $db = DbManager::getPDO();
        $query = "INSERT INTO Opinion(stars, description, idUser, idShelter) "
                ."VALUES (".$stars.", '".$description."',".$idUser.",".$idShelter.")";
        return ($db->exec($query)>=0);
    }
    
    public static function addOpinion($stars, $description, $nickname, $idShelter) {
        if(User::isUserExistInDataBase($nickname)) {
            if(Shelter::isShelterExistInDataBase($idShelter)) {
                $user = new User($nickname);
                return Opinion::addOpinionInDataBase($stars, $description, $user->idUser, $idShelter);
            } else {
                return "Unknown shelter";
            }
        } else {
            return "Unknown user";
        }
    }
    
}