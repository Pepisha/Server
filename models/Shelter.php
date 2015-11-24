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

  public static function getSheltersAnimals($idShelter) {
    $db = DbManager::getPDO();
    $query = "SELECT * FROM Animal WHERE idShelter = ".$idShelter." AND idState = ".Animal::$STATE_ADOPTION.";";
    $res = $db->query($query)->fetchAll();
    for ($i=0; $i<count($res); $i++) {
      $animal = Animal::getAnimalArrayFromFetch($res[$i]);
      $listAnimals[$animal['idAnimal']] = $animal;
    }

    return $listAnimals;
  }

  /**
   * @return true si l'enregistrement en bdd c'est bien fais, false sinon
   */
  private static function addAdministratorInDataBase($idShelter, $idUser) {
    $db = DbManager::getPDO();
    $query = "INSERT INTO IsAdmin(idUser, idShelter)
              VALUES (".$idUser.", ".$idShelter.");";
    return ($db->exec($query)>=0);
  }

  /**
   * @return true si l'enregistrement c'est bien fais, false sinon,
   *         "Unknown shelter" si le refuge n'est pas dans la BDD,
   *         "Unknown user" si l'utilisateur n'est pas dans la BDD
   */
  public static function addAdministrator($idShelter, $nickname) {
    if(Shelter::isShelterExistInDataBase($idShelter)) {
      if(User::isUserExistInDataBase($nickname)) {
          $user = new User($nickname);
          return Shelter::addAdministratorInDataBase($idShelter,$user->idUser);
      } else {
        return "Unknown user";
      }
    } else {
      return "Unknown shelter";
    }
  }
}


 ?>