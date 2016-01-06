<?php
require_once 'models/Address.php';
require_once 'models/Animal.php';
require_once 'models/User.php';
require_once 'tools/arrayOperation.php';

class Shelter {
  private $idShelter;
  private $name;
  private $phone;
  private $idAddress;
  private $address;
  private $description;
  private $mail;
  private $website;
  private $operationalHours;

  public function __construct($idShelter) {
    $db = DbManager::getPDO();
    $query = "SELECT * FROM Shelter s, Address a WHERE s.idAddress = a.idAddress AND idShelter = ".$idShelter;
    $res = $db->query($query)->fetch();
    $this->idShelter = $res['idShelter'];
    $this->name = $res['name'];
    $this->phone = $res['phone'];
    $this->idAddress = $res['idAddress'];
    $this->address = $res['street'] . " " . $res['zipcode'] . " " . $res['city'];
    $this->description = $res['description'];
    $this->mail = $res['mail'];
    $this->website = $res["website"];
    $this->operationalHours = $res['operationalHours'];
  }

  public function getInformations() {
    $shelterArray["idShelter"] = intval($this->idShelter);
    $shelterArray["name"] = $this->name;
    $shelterArray["phone"] = $this->phone;
    $shelterArray["address"] = $this->address;
    $shelterArray["description"] = $this->description;
    $shelterArray["mail"] = $this->mail;
    $shelterArray["website"] = $this->website;
    $shelterArray["operationalHours"] = $this->operationalHours;
    $shelterArray["average"] = $this->getOpinionsAverage();
    return $shelterArray;
  }

  public static function isShelterExistInDataBase($idShelter) {
    $db = DbManager::getPDO();
    $query = "SELECT idShelter FROM Shelter WHERE idShelter='".$idShelter."';";
    $res = $db->query($query)->fetch();
    return $res['idShelter'] === $idShelter;
  }

  public static function addShelterInDataBase($name, $phone, $description, $mail, $website, $operationalHours, $street, $zipcode, $city, $latitude, $longitude){
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

  public function isAnimalInShelter($idAnimal) {
    $db = DbManager::getPDO();
    $query = "SELECT idAnimal FROM Animal WHERE idAnimal = ".$idAnimal." AND idShelter = ".$this->idShelter.";";
    $res = $db->query($query)->fetch();
    return $res['idAnimal'] === $idAnimal;
  }

  public function deleteAnimal($idAnimal) {
    if($this->isAnimalInShelter($idAnimal)) {
        $db = DbManager::getPDO();
        $query = "UPDATE Animal SET idShelter = null WHERE idAnimal = ".$idAnimal.";";
        return $db->exec($query) >= 0;
    } else {
      return "animal not in shelter";
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
    $arrayShelter["address"] = $shelter['street'] . " " . $shelter['zipcode'] . " " . $shelter['city'];
    $arrayShelter["description"] = $shelter["description"];
    $arrayShelter["mail"] = $shelter["mail"];
    $arrayShelter["website"] = $shelter["website"];
    $arrayShelter["operationalHours"] = $shelter["operationalHours"];
    return $arrayShelter;
  }

  public static function getAllShelters() {
    $db = DbManager::getPDO();
    $query = "SELECT * FROM Shelter s, Address a WHERE s.idAddress = a.idAddress";
    $res = $db->query($query)->fetchAll();

    for ($i=0; $i<count($res); $i++) {
      $shelter = Shelter::getShelterArrayFromFetch($res[$i]);
      $listShelters[$shelter['idShelter']] = $shelter;
      $shelterObject = new Shelter($shelter['idShelter']);
      $listShelters[$shelter['idShelter']]["average"] = $shelterObject->getOpinionsAverage();
    }

    return $listShelters;
  }

  /**
   * @param numberOfAnimals nombre d'animaux attendus.
   * @return Si numberOfAnimals === null, on retourne la liste de tous les animaux.
  *          Sinon, on prend numberOfAnimals animaux aléatoirement dans la liste des animaux du refuge
   */
  public function getAnimals($numberOfAnimals = null) {
    $db = DbManager::getPDO();
    $query = "SELECT * FROM Animal WHERE idShelter = ".$this->idShelter." AND idState = ".Animal::$STATE_ADOPTION.";";
    $res = $db->query($query)->fetchAll();

    for ($i=0; $i<count($res); $i++) {
      $animal = Animal::getAnimalArrayFromFetch($res[$i]);
      $listAnimals[$animal['idAnimal']] = $animal;
    }

    if ($numberOfAnimals !== null && $numberOfAnimals > 0) {
      $listAnimals = getRandomNbElements($listAnimals, $numberOfAnimals);
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

  public function getOpinions($numberOfOpinions = null) {
    $db = DbManager::getPDO();
    $query = "SELECT * FROM Opinion WHERE idShelter = ".$this->idShelter;
    $res = $db->query($query)->fetchAll();

    if($numberOfOpinions !== null && $numberOfOpinions > 0) {
      $i = 0;
      while ($i < count($res) && $i < $numberOfOpinions) {
        $indexOpinion = rand(0, count($res)-1);
        $opinion = Opinion::getOpinionArrayFromFetch($res[$i]);
        $listOpinions[$opinion['idOpinion']] = $opinion;
        array_splice($res, $indexOpinion, 1);

        $i++;
      }
    } else {
      for ($i=0; $i<count($res); $i++) {
        $opinion = Opinion::getOpinionArrayFromFetch($res[$i]);
        $listOpinions[$opinion['idOpinion']] = $opinion;
      }
    }

    return $listOpinions;
  }

  /**
   * @return la liste des messages correspondant au refuge mais pas par rapport à un animal en particulier
   */
  public function getMessages() {
    $db = DbManager::getPDO();
    $query = "SELECT * FROM Message WHERE idShelter = ".$this->idShelter." AND idAnimal IS NULL ORDER BY dateMessage";
    $res = $db->query($query)->fetchAll();

    for ($i = 0; $i < count($res); $i++) {
      $message = Message::getMessageArrayFromFetch($res[$i]);
      $listSheltersMessages[$message['idMessage']] = $message;
    }

    return $listSheltersMessages;
  }

  /**
   * @return la liste des messages sur des animaux du refuge
   */
  public function getMessagesAboutAnimals() {
    $db = DbManager::getPDO();
    $query = "SELECT * FROM Message WHERE idShelter = ".$this->idShelter." AND idAnimal IS NOT NULL ORDER BY dateMessage";
    $res = $db->query($query)->fetchAll();

    for ($i = 0; $i < count($res); $i++) {
      $message = Message::getMessageArrayFromFetch($res[$i]);
      $listSheltersMessages[$message['idMessage']] = $message;
    }

    return $listSheltersMessages;
  }

  private function calculateAverage($listAverages) {
    $totalNotes = 0;

    for ($i=0; $i<count($listAverages); $i++) {
      $totalNotes = $totalNotes + intval($listAverages[$i]['stars']);
    }

    if(count($listAverages) > 0) {
      $average = $totalNotes/count($listAverages);
    } else {
      $average = 0;
    }
    return $average;
  }

  public function getOpinionsAverage() {
    $db = DbManager::getPDO();
    $query = "SELECT stars FROM Opinion WHERE idShelter = ".$this->idShelter.";";
    $listAverages = $db->query($query)->fetchAll();

    return $this->calculateAverage($listAverages);
  }


}


 ?>
