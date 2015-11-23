<?php
require_once 'models/Address.php';
require_once 'models/Animal.php';

class Shelter {
  private $idShelter;
  private $name;
  private $phone;
  private $idAddress;
  private $description;
  private $email;
  private $operationalHours;
  private $idFacebook;
  private $idTwitter;
  private $idInstagram;

  public function __construct($idShelter) {
    $db = DbManager::getPDO();
    $query = "SELECT * FROM Shelter WHERE idShelter = '".$idShelter."';";
    $res = $db->query($query)->fetch();
    $this->idShelter = $res['idShelter'];
    $this->name = $res['name'];
    $this->phone = $res['phone'];
    $this->idAddress = $res['idAddress'];
    $this->description = $res['description'];
    $this->email = $res['email'];
    $this->operationalHours = $res['operationalHours'];
    $this->idFacebook = $res['idFacebook'];
    $this->idTwitter = $res['idTwitter'];
    $this->idInstagram = $res['idInstagram'];
  }

  public static function isShelterExistInDataBase($idShelter) {
    $db = DbManager::getPDO();
    $query = "SELECT idShelter FROM Shelter WHERE idShelter='".$idShelter."';";
    $res = $db->query($query)->fetch();
    return $result['idShelter'] === $idShelter;
  }

  public static function addShelterInDataBase($name, $phone, $description, $email, $operationalHours, $street, $zipcode, $city, $latitude, $longitude){
    $db = DbManager::getPDO();
    $idAddress = Address::addAddress($street, $zipcode, $city, $latitude, $longitude);

    $query = "INSERT INTO Shelter(name, phone, idAddress, description, mail, operationalHours )
              VALUES ('".$name."','".$phone."','".$idAddress."','".$description."','".$mail."','".$operationalHours."')";
    return $db->exec($query);
  }

  private static function linkAnimalToShelter($idAnimal, $idShelter) {
    $db = DbManager::getPDO();
    $query = "INSERT INTO AnimalShelter(idAnimal, idShelter) VALUES (".$idAnimal.",".$idShelter.")";
    return $db->exec($query);
  }

  public static function addAnimalInShelter($idShelter, $type, $name, $breed, $age, $gender, $catsFriend, $dogsFriend, $childrenFriend, $description, $state){
    if(Shelter::isShelterExistInDataBase($idShelter)) {
      $addAnimalResult = Animal::addAnimalInDataBase($type, $name, $breed, $age, $gender, $catsFriend, $dogsFriend,
                                                     $childrenFriend, $description, $state);
      if($addAnimalResult) {
        $idAnimal = Animal::getIdAnimal($type, $name, $breed, $age, $gender, $catsFriend, $dogsFriend,
                                        $childrenFriend, $description, $state);
        $linkResult = Shelter::linkAnimalToShelter($idAnimal,$idShelter);
        return $linkResult;
      } else {
        return $addAnimalResult;
      }
    } else {
      return "Unknown shelter";
    }
  }
}


 ?>
