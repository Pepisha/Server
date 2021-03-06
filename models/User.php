<?php

require_once 'models/Animal.php';
require_once 'models/Shelter.php';
require_once 'models/Message.php';

class User {

  private $idUser;
  private $nickname;
  private $password;
  private $mail;
  private $phone;
  private $firstname;
  private $lastname;
  private $admin;

  public function __construct($nickname) {
    $db = DbManager::getPDO();
    $query = "SELECT * FROM User WHERE nickname = '".$nickname."'";
    $res = $db->query($query)->fetch();
    $this->idUser = $res['idUser'];
    $this->nickname = $res['nickname'];
    $this->password = $res['password'];
    $this->mail = $res['mail'];
    $this->phone = $res['phone'];
    $this->firstname = $res['firstname'];
    $this->lastname = $res['lastname'];
    $this->admin = $res['admin'];
  }

  public function getId() {
    return $this->idUser;
  }

  public function getNickname() {
    return $this->nickname;
  }

  public function getAdmin() {
    return $this->admin;
  }

  public static function getNicknameFromId($idUser) {
    $db = DbManager::getPDO();
    $query = "SELECT nickname FROM User WHERE idUser = ".$idUser;
    $res = $db->query($query)->fetch();

    return $res['nickname'];
  }

  public function getUsersInformationsArray() {
    $userArray['nickname'] = $this->nickname;
    $userArray['password'] = $this->password;
    $userArray['mail'] = $this->mail;
    $userArray['phone'] = $this->phone;
    $userArray['firstname'] = $this->firstname;
    $userArray['lastname'] = $this->lastname;
    $userArray['admin'] = $this->admin;
    return $userArray;
  }

/**
 * @return true si l'utilisateur existe dans la BD, false sinon.
 */
  public static function isUserExistInDataBase($nickname) {
      $db = DbManager::getPDO();
      $query = "SELECT nickname FROM User WHERE nickname='".$nickname."';";
      $result = $db->query($query)->fetch();
      return ($result['nickname'] === $nickname);
  }

  /**
   * @return true si le nickname et le password sont bons, false sinon.
   */
  public static function canUserLogin($nickname, $password) {
      $db = DbManager::getPDO();
      $query = "SELECT nickname FROM User WHERE nickname='".$nickname."' AND password='".$password."';";
      $result = $db->query($query)->fetch();
      return $result['nickname'] === $nickname;
  }


  /**
   * @return null si l'utilisateur n'a pas pu être créé. L'utilisateur sinon.
   */
  public static function registerIfPossible($nickname, $password1, $password2, $mail, $phone, $firstname, $lastname) {
    if(!empty($nickname) && !empty($password1) && !empty($password2)
      && !empty($mail) && !empty($phone) && !empty($firstname) && !empty($lastname)) {
      if($password1 === $password2) {
        if(!User::isUserExistInDataBase($nickname)) {
          return User::addUserInDataBase($nickname, $password1, $mail, $phone, $firstname, $lastname);
        } else {
          return "User already exist";
        }
      } else{
        return "Passwords differents";
      }
    } else {
      return "Empty required value(s)";
    }
  }

  /**
   * @return l'utilisateur ajouté dans la BDD
   */
  public static function addUserInDataBase($nickname, $password, $mail, $phone, $firstname, $lastname) {
    $db = DbManager::getPDO();
    $query="INSERT INTO User(nickname, password, email, phone, firstname, lastname, admin) VALUES ("
            ."'".$nickname."','".$password."','".$mail."','"
            .$phone."','".$firstname."','".$lastname."', 0);";

    $db->query($query);
    return new User($nickname);
  }

  /**
   * @action met à jour le mail de l'utilisateur si newMail est différent de null
   * @return true si tout va bien, false s'il y a eu une erreur au moment de la requete sql.
   */
  private function updateMailIfNeeded($newMail) {
    if(!empty($newMail)) {
      $db = DbManager::getPDO();
      $query = "UPDATE User SET email = '".$newMail."' WHERE nickname = '".$this->nickname."'";
      return $db->query($query);
    }
    return true;
  }

  /**
   * @action met à jour le password de l'utilisateur si possible
   * @return true si tout va bien, false si erreur sql ou newPassword !== confirmNewPassword
   */
  private function updatePasswordIfNeeded($newPassword, $confirmNewPassword) {
    if(!empty($newPassword) && !empty($confirmNewPassword)) {
      if($newPassword === $confirmNewPassword) {
        $db = DbManager::getPDO();
        $query = "UPDATE User SET password = '".$newPassword."' WHERE nickname = '".$this->nickname."'";
        return $db->query($query);
      } else {
        return false;
      }
    } else {
      return true;
    }
  }

  /**
   * @action met à jour le phone de l'utilisateur si newPhone est différent de null
   * @return true si tout va bien, false s'il y a eu une erreur au moment de la requete sql.
   */
  private function updatePhoneIfNeeded($newPhone) {
    if(!empty($newPhone)) {
      $db = DbManager::getPDO();
      $query = "UPDATE User SET phone = '".$newPhone."' WHERE nickname = '".$this->nickname."'";
      return $db->query($query);
    } else {
      return true;
    }
  }

  /**
   * @action met à jour le firstname de l'utilisateur si newFirstname est différent de null
   * @return true si tout va bien, false s'il y a eu une erreur au moment de la requete sql.
   */
  private function updateFirstnameIfNeeded($newFirstname) {
    if(!empty($newFirstname)) {
      $db = DbManager::getPDO();
      $query = "UPDATE User SET firstname = '".$newFirstname."' WHERE nickname = '".$this->nickname."'";
      return $db->query($query);
    } else {
      return true;
    }
  }

  /**
   * @action met à jour le lastname de l'utilisateur si newLastname est différent de null
   * @return true si tout va bien, false s'il y a eu une erreur au moment de la requete sql.
   */
  private function updateLastnameIfNeeded($newLastname) {
    if(!empty($newLastname)) {
      $db = DbManager::getPDO();
      $query = "UPDATE User SET lastname = '".$newLastname."' WHERE nickname = '".$this->nickname."'";
      return $db->query($query);
    } else {
      return true;
    }
  }

  /**
   * @action met à jour le profil de l'utilisateur en fonction des nouvelles informations
   * @return true si tout c'est bien passé, false si un problème a été rencontré à la MAJ d'un champ,
   *         "Unknown nickname" si le pseudo de l'utilisateur est inconnu.
   */
  public function updateProfile($newPassword, $confirmNewPassword, $newMail, $newPhone, $newFirstname, $newLastname) {
    return $this->updateMailIfNeeded($newMail)
        && $this->updatePasswordIfNeeded($newPassword, $confirmNewPassword)
        && $this->updatePhoneIfNeeded($newPhone)
        && $this->updateFirstnameIfNeeded($newFirstname)
        && $this->updateLastnameIfNeeded($newLastname);
  }

  /**
   * @return true si la suppression c'est bien passée, false sinon.
   */
  public function delete() {
      $db = DbManager::getPDO();
      $query = "DELETE FROM User WHERE nickname = '".$this->nickname."'";
      return $db->exec($query) > 0;
  }

  public function isFollowingAnimal($idAnimal) {
    $db = DbManager::getPDO();
    $query = "SELECT idUser FROM FollowAnimal WHERE idUser=".$this->idUser." AND idAnimal=".$idAnimal;
    $result = $db->query($query)->fetch();
    return $result['idUser'] === $this->idUser;
  }

  public function followAnimal($idAnimal) {
    if(Animal::isAnimalExistInDataBase($idAnimal)) {
      $db = DbManager::getPDO();
      $query = "INSERT INTO FollowAnimal(idUser, idAnimal) VALUES (".$this->idUser.",".$idAnimal.")";
      return ($db->exec($query)>=0);
    } else {
      return "Unknown animal";
    }
  }

  public function unfollowAnimal($idAnimal) {
    $db = DbManager::getPDO();
    $query = "DELETE FROM FollowAnimal WHERE idUser = ".$this->idUser." AND idAnimal = " . $idAnimal;
    return $db->query($query) > 0;
  }

  public function isFollowingShelter($idShelter) {
    $db = DbManager::getPDO();
    $query = "SELECT idUser FROM FollowShelter WHERE idUser=".$this->idUser." AND idShelter=".$idShelter;
    $result = $db->query($query)->fetch();
    return $result['idUser'] === $this->idUser;
  }

  public function followShelter($idShelter) {
    if(Shelter::isShelterExistInDataBase($idShelter)) {
      $db = DbManager::getPDO();
      $query = "INSERT INTO FollowShelter(idUser, idShelter) VALUES (".$this->idUser.",".$idShelter.")";
      return ($db->exec($query)>=0);
    } else {
      return "Unknown shelter";
    }
  }

  public function unfollowShelter($idShelter) {
    $db = DbManager::getPDO();
    $query = "DELETE FROM FollowShelter WHERE idUser = ".$this->idUser." AND idShelter = " . $idShelter;
    return $db->exec($query) > 0;
  }

  public function getAnimals() {
    $db = DbManager::getPDO();
    $query = "SELECT * FROM Animal WHERE idOwner=".$this->idUser;
    $res = $db->query($query)->fetchAll();
    for($i = 0; $i < count($res); $i++) {
        $animal = Animal::getAnimalArrayFromFetch($res[$i]);
        $listUsersAnimals[$animal['idAnimal']] = $animal;
    }

    return $listUsersAnimals;
  }

  public static function getUserArrayFromFetch($user) {
    $userArray["nickname"] = $user["nickname"];
    $userArray['password'] = $user["password"];
    $userArray['mail'] = $user["mail"];
    $userArray['phone'] = $user["phone"];
    $userArray['firstname'] = $user["firstname"];
    $userArray['lastname'] = $user["lastname"];
    $userArray['admin'] = $user["admins"];

    return $userArray;
  }

  public static function getAllUsers() {
    $db = DbManager::getPDO();
    $query = "SELECT * FROM User";
    $res = $db->query($query)->fetchAll();

    for($i = 0; $i < count($res); $i++) {
      $user = User::getUserArrayFromFetch($res[$i]);
      $listUsers[$user['nickname']] = $user;
    }

    return $listUsers;
  }

  public function getFollowedAnimals() {
    $db = DbManager::getPDO();
    $query = "SELECT * FROM Animal an, FollowAnimal fa WHERE an.idAnimal = fa.idAnimal AND fa.idUser = ".$this->idUser;
    $res = $db->query($query)->fetchAll();
    for($i = 0; $i < count($res); $i++) {
      $animal = Animal::getAnimalArrayFromFetch($res[$i]);
      $listFollowedAnimals[$animal['idAnimal']] = $animal;
      $listFollowedAnimals[$animal['idAnimal']]['followed'] = true;
    }

    return $listFollowedAnimals;
  }

  public function setFollowedAnimals($animalsList) {
    if (!is_null($animalsList) && is_array($animalsList)) {
      foreach ($animalsList as $idAnimal => $animal) {
        $db = DbManager::getPDO();
        $query = "SELECT * FROM FollowAnimal WHERE idAnimal = ".$idAnimal." AND idUser = ".$this->idUser;
        $res = $db->query($query)->fetch();
        if ($res) {
          $animalsList[$idAnimal]['followed'] = true;
        } else {
          $animalsList[$idAnimal]['followed'] = false;
        }
      }
    }

    return $animalsList;
  }

  public function getFollowedShelters() {
    $db = DbManager::getPDO();
    $query = "SELECT * FROM Shelter s, Address a, FollowShelter fs "
            . "WHERE s.idAddress = a.idAddress AND s.idShelter = fs.idShelter AND fs.idUser = ".$this->idUser;
    $res = $db->query($query)->fetchAll();
    for($i = 0; i < count($res); $i++) {
      $shelter = Shelter::getShelterArrayFromFetch($res[$i]);
      $listFollowedShelters[$shelter['idShelter']] = $animal;
      $listFollowedShelters[$shelter['idShelter']]['followed'] = true;
    }

    return $listFollowedShelters;
  }

  public function setFollowedShelters($sheltersList) {
    foreach ($sheltersList as $idShelter => $shelter) {
      $db = DbManager::getPDO();
      $query = "SELECT * FROM FollowShelter WHERE idShelter = ".$idShelter." AND idUser = ".$this->idUser;
      $res = $db->query($query)->fetch();
      if ($res) {
        $sheltersList[$idShelter]['followed'] = true;
      } else {
        $sheltersList[$idShelter]['followed'] = false;
      }
    }

    return $sheltersList;
  }

  public function isAdmin() {
    return boolval($this->admin);
  }

  public function isUserAnimalsOwner($idAnimal) {
    $db = DbManager::getPDO();
    $query = "SELECT idAnimal FROM Animal WHERE idOwner = ".$this->idUser." AND idAnimal = ".$idAnimal;
    return ($db->exec($query)>=0);
  }

  public function getPetsPreferences() {
    $db = DbManager::getPDO();
    $query = "SELECT * FROM UserPreferences WHERE idUser = " . $this->idUser;
    $res = $db->query($query)->fetch();

    $preferences = array();
    if (!is_null($res['catsFriend'])) {
      $preferences['catsFriend'] = $res['catsFriend'];
    }

    if (!is_null($res['dogsFriend'])) {
      $preferences['dogsFriend'] = $res['dogsFriend'];
    }

    if (!is_null($res['childrenFriend'])) {
      $preferences['childrenFriend'] = $res['childrenFriend'];
    }

    if (!is_null($res['idType'])) {
      $preferences['idType'] = $res['idType'];
    }

    return $preferences;
  }

  public function setPetsPreferences($catsFriend, $dogsFriend, $childrenFriend, $idType) {
    $db = DbManager::getPDO();
    $query = "SELECT idUser FROM UserPreferences WHERE idUser = " . $this->idUser;
    $res = $db->query($query);

    $catsFriend = !(is_null($catsFriend)) ? $catsFriend : "NULL";
    $dogsFriend = !(is_null($dogsFriend)) ? $dogsFriend : "NULL";
    $childrenFriend = !(is_null($childrenFriend)) ? $childrenFriend : "NULL";
    $idType = !(is_null($idType)) ? $idType : "NULL";

    if ($res->fetch()) {
      $query = "UPDATE UserPreferences SET catsFriend = ".$catsFriend.", dogsFriend = ".$dogsFriend.", childrenFriend = ".$childrenFriend
                                              .", idType = ".$idType
               . " WHERE idUser = " . $this->idUser;
    } else {
      $query = "INSERT INTO UserPreferences (idUser, catsFriend, dogsFriend, childrenFriend, idType) "
                . "VALUES (".$this->idUser.",".$catsFriend.",".$dogsFriend.",".$childrenFriend.",".$idType.")";
    }

    return ($db->exec($query) >= 0);
  }

  public function changeAnimalUserPreferences($catsFriend, $dogsFriend, $childrenFriend, $idType) {
    $newListAnimals = Animal::getHomelessAnimals($idType, $catsFriend, $dogsFriend, $childrenFriend);

    $db = DbManager::getPDO();
    $query = "SELECT * FROM AnimalUserPreferences WHERE idUser = " . $this->idUser;
    $res = $db->query($query);

    // Pour chaque ancien animal correspondant
    while ($row = $res->fetch()) {

      // On regarde s'il est dans la nouvelle liste
      foreach ($newListAnimals as $idAnimal => $animal) {
        if ($row['idAnimal'] == $idAnimal) {
          $newListAnimals[$idAnimal]['seen'] = $row['seen'];
        }
      }
    }

    $query = "DELETE FROM AnimalUserPreferences WHERE idUser = " . $this->idUser;
    $db->exec($query);

    foreach ($newListAnimals as $idAnimal => $animal) {
      if (is_null($animal['seen'])) {
        $query = "INSERT INTO AnimalUserPreferences (idUser, idAnimal) VALUES ("
                .$this->idUser.",".$idAnimal.")";
      } else {
        $query = "INSERT INTO AnimalUserPreferences (idUser, idAnimal, seen) VALUES ("
                .$this->idUser.",".$idAnimal.",".$animal['seen'].")";
      }

      $db->exec($query);
    }
  }

  public function sendMessage($content, $idShelter, $idAnimal = null) {
    return Message::addMessageInDataBase($content, $this->idUser, $idShelter, $idAnimal);
  }

  public function setInterestedOnAnimal($idAnimal) {
    if (!Animal::isAnimalExistInDataBase($idAnimal)) {
      return "Unknown animal";
    }

    $db = DbManager::getPDO();
    $query = "INSERT INTO IsInterestedBy (idUser, idAnimal) VALUES (".$this->idUser.",".$idAnimal.")";
    return $db->exec($query) > 0;
  }

  public function setNotInterestedOnAnimal($idAnimal) {
    $db = DbManager::getPDO();
    $query = "DELETE FROM IsInterestedBy WHERE idUser = ".$this->idUser." AND idAnimal = " . $idAnimal;
    return $db->exec($query) > 0;
  }

  public function getAnimalCorrespondingToUserPreferences() {
    $db = DbManager::getPDO();
    $query = "SELECT * FROM AnimalUserPreferences aup, Animal a
              WHERE aup.idAnimal = a.idAnimal
              AND aup.idUser = ".$this->idUser."
              AND seen = false";
    $res = $db->query($query)->fetchAll();

    if (count($res) > 0) {
      for ($i=0; $i < count($res); $i++) {
        $animal = Animal::getAnimalArrayFromFetch($res[$i]);
        $listAnimals[$animal['idAnimal']] = $animal;
      }

      $listAnimals = $this->setFollowedAnimals($listAnimals);
      $randAnimal = getRandomNbElements($listAnimals, 1);

      return current($randAnimal);
    }

    return null;
  }

  public function haveSeenAnimal($idAnimal) {
    $db = DbManager::getPDO();
    $query = "UPDATE AnimalUserPreferences SET seen = 1 WHERE idUser = ".$this->idUser." AND idAnimal = ".$idAnimal;
    $db->exec($query);
  }
}
