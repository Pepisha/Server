<?php

require_once 'models/Animal.php';
require_once 'models/Shelter.php';

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

  public function getUsersInformationsArray() {
    $userArray['nickname'] = $this->nickname;
    $userArray['password'] = $this->password;
    $userArray['mail'] = $this->mail;
    $userArray['phone'] = $this->phone;
    $userArray['firstname'] = $this->firstname;
    $userArray['lastname'] = $this->lastname;
    return $userArray;
  }

/**
 * @return true si l'utilisateur existe dans la BD, false sinon.
 */
  public static function isUserExistInDataBase($nickname) {
      $db = DbManager::getPDO();
      $query = "SELECT nickname FROM User WHERE nickname='".$nickname."';";
      return ($db->exec($query)>=0);
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
    $query = "SELECT * FROM Animal an, Adopt ad WHERE an.idAnimal=ad.idAnimal AND ad.idUser=".$this->idUser;
    $res = $db->query($query)->fetchAll();
    for($i = 0; $i < count($res); $i++) {
        $animal = Animal::getAnimalArrayFromFetch($res[$i]);
        $listUsersAnimals[$animal['idAnimal']] = $animal;
    }

    return $listUsersAnimals;
  }

  public function getFollowedAnimals() {
    $db = DbManager::getPDO();
    $query = "SELECT * FROM Animal an, FollowAnimal fa WHERE an.idAnimal = fa.idAnimal AND fa.idUser = ".$this->idUser.";";
    $res = $db->query($query)->fetchAll();
    for($i = 0; i < count($res); $i++) {
      $animal = Animal::getAnimalArrayFromFetch($res[$i]);
      $listFollowedAnimals[$animal['idAnimal']] = $animal;
    }

    return $listFollowedAnimals;
  }

  public function getFollowedShelters() {
    $db = DbManager::getPDO();
    $query = "SELECT * FROM Shelter s, FollowShelter fs WHERE s.idShelter = fs.idShelter AND fs.idUser = ".$this->idUser.";";
    $res = $db->query($query)->fetchAll();
    for($i = 0; i < count($res); $i++) {
      $shelter = Shelter::getShelterArrayFromFetch($res[$i]);
      $listFollowedShelters[$shelter['idShelter']] = $animal;
    }

    return $listFollowedShelters;
  }

  public function isAdmin() {
    return boolval($this->admin);
  }
}
