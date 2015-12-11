<?php
require_once 'models/Address.php';
require_once 'models/Animal.php';
require_once 'models/User.php';

class Shelter {
  private $idShelter;
  private $name;
  private $phone;
  private $idAddress;
  private $description;
  private $email;
  private $website;
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
    $this->website = $res["website"];
    $this->operationalHours = $res['operationalHours'];
    $this->idFacebook = $res['idFacebook'];
    $this->idTwitter = $res['idTwitter'];
    $this->idInstagram = $res['idInstagram'];
  }

  public function getInformations() {
    $shelterArray["idShelter"] = intval($this->idShelter);
    $shelterArray["name"] = $this->name;
    $shelterArray["phone"] = $this->phone;
    $shelterArray["idAddress"] = intval($this->idAddress);
    $shelterArray["description"] = $this->description;
    $shelterArray["email"] = $this->email;
    $shelterArray["website"] = $this->website;
    $shelterArray["operationalHours"] = $this->operationalHours;
    return $shelterArray;
  }

  public static function isShelterExistInDataBase($idShelter) {
    $db = DbManager::getPDO();
    $query = "SELECT idShelter FROM Shelter WHERE idShelter='".$idShelter."';";
    $res = $db->query($query)->fetch();
    return $res['idShelter'] === $idShelter;
  }

  public static function addShelterInDataBase($name, $phone, $description, $email, $website, $operationalHours, $street, $zipcode, $city, $latitude, $longitude){
    $db = DbManager::getPDO();
    $idAddress = Address::addAddress($street, $zipcode, $city, $latitude, $longitude);

    $query = "INSERT INTO Shelter(name, phone, idAddress, description, mail, website, operationalHours )
              VALUES ('".$name."','".$phone."','".$idAddress."','".$description."','".$mail."','".$website."','".$operationalHours."')";
    return $db->exec($query);
  }

  public function addAnimal($type, $name, $breed, $age, $gender, $catsFriend, $dogsFriend,
                                               $childrenFriend, $description) {
    $db = DbManager::getPDO();
    $query = "INSERT INTO Animal(idType, name, breed, age, gender, catsFriend, dogsFriend, childrenFriend, description, idState, idShelter)
                VALUES (".$type.",'".$name."','".$breed."','".$age."','".$gender."','".$catsFriend."','".$dogsFriend."','".$childrenFriend."',
                '".$description."',".Animal::$STATE_ADOPTION.",".$this->idShelter.");";

    return $db->exec($query);
  }

  /**
   * @return transforme le résultat du fetch d'un refuge en un tableau contenant
   *         les informations du refuge pour ensuite le transmettre au clien
   */
  public static function getShelterArrayFromFetch($shelter) {
    $arrayShelter["idShelter"] = intval($shelter["idShelter"]);
    $arrayShelter["name"] = $shelter["name"];
    $arrayShelter["phone"] = $shelter["phone"];
    $arrayShelter["idAddress"] = intval($shelter["idAddress"]);
    $arrayShelter["description"] = $shelter["description"];
    $arrayShelter["mail"] = $shelter["mail"];
    $arrayShelter["website"] = $shelter["website"];
    $arrayShelter["operationalHours"] = $shelter["operationalHours"];
    $arrayShelter["idFacebook"] = intval($shelter["idFacebook"]);
    $arrayShelter["idTwitter"] = intval($shelter["idTwitter"]);
    $arrayShelter["idInstagram"] = intval($shelter["idInstagram"]);
    return $arrayShelter;
  }

  public static function getAllShelters() {
    $db = DbManager::getPDO();
    $query = "SELECT * FROM Shelter;";
    $res = $db->query($query)->fetchAll();

    for ($i=0; $i<count($res); $i++) {
      $shelter = Shelter::getShelterArrayFromFetch($res[$i]);
      $listShelters[$shelter['idShelter']] = $shelter;
    }

    return $listShelters;
  }

  public function getAnimals() {
    $db = DbManager::getPDO();
    $query = "SELECT * FROM Animal WHERE idShelter = ".$this->idShelter." AND idState = ".Animal::$STATE_ADOPTION.";";
    $res = $db->query($query)->fetchAll();
    for ($i=0; $i<count($res); $i++) {
      $animal = Animal::getAnimalArrayFromFetch($res[$i]);
      $listAnimals[$animal['idAnimal']] = $animal;
    }

    return $listAnimals;
  }

  public function getAdoptedAnimals() {
    $db = DbManager::getPDO();
    $query = "SELECT * FROM Animal WHERE idShelter = ".$this->idShelter." AND idState = ".Animal::$STATE_ADOPTED.";";
    $res = $db->query($query)->fetchAll();
    for ($i=0; $i<count($res); $i++) {
      $animal = Animal::getAnimalArrayFromFetch($res[$i]);
      $listAdoptedAnimals[$animal['idAnimal']] = $animal;
    }

    return $listAdoptedAnimals;
  }

  public function isAdministrator($idUser) {
    $db = DbManager::getPDO();
    $query = "SELECT idShelter FROM IsAdmin WHERE idShelter=".$this->idShelter." AND idUser=".$idUser;
    $result = $db->query($query)->fetch();
    return $result['idShelter'] === $this->idShelter;
  }

  /**
   * @return true si l'enregistrement en bdd c'est bien fait
   *          "Unknown user" si l'utilisateur n'est pas dans la BDD
   */
  public function addAdministrator($idUser) {
    if(User::isUserExistInDataBase($nickname)) {
      $db = DbManager::getPDO();
      $query = "INSERT INTO IsAdmin(idUser, idShelter)
                VALUES (".$idUser.", ".$this->idShelter.");";
      return ($db->exec($query)>=0);
    } else {
      return "Unknown user";
    }
  }

  public function isManager($idUser) {
    $db = DbManager::getPDO();
    $query = "SELECT idShelter FROM Manages WHERE idShelter=".$this->idShelter." AND idUser=".$idUser;
    $result = $db->query($query)->fetch();
    return $result['idShelter'] === $this->idShelter;
  }

  /**
   * @return true si l'enregistrement c'est bien fais, false sinon,
   *         "Unknown user" si l'utilisateur n'est pas dans la BDD
   */
  public function addManager($idUser) {
    if(User::isUserExistInDataBase($nickname)) {
      $db = DbManager::getPDO();
      $query = "INSERT INTO Manages(idUser, idShelter)
                VALUES (".$idUser.", ".$idShelter.");";
      return ($db->exec($query)>=0);
    } else {
      return "Unknown user";
    }
  }

  public function getOpinions() {
    $db = DbManager::getPDO();
    $query = "SELECT * FROM Opinion WHERE idShelter = ".$this->idShelter.";";
    $res = $db->query($query)->fetchAll();

    for ($i=0; $i<count($res); $i++) {
      $opinion = Opinion::getOpinionArrayFromFetch($res[$i]);
      $listOpinions[$opinion['idOpinion']] = $opinion;
    }
    return $listOpinions;
  }
}


 ?>
