<?php

require_once 'models/Animal.php';

class User {

private $idUser;
private $nickname;
private $password;
private $mail;
private $phone;
private $firstname;
private $lastname;

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
  }

/**
 * @return true si l'utilisateur existe dans la BD, false sinon.
 */
  public static function isUserExistInDataBase($nickname) {
      $db = DbManager::getPDO();
      $query = "SELECT nickname FROM User WHERE nickname='".$nickname."';";
      $res = $db->query($query)->fetch();
      return $result['nickname'] === $nickname;
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
    $query="INSERT INTO User(nickname, password, email, phone, firstname, lastname) VALUES ("
            ."'".$nickname."','".$password."','".$mail."','"
            .$phone."','".$firstname."','".$lastname."');";

    $db->query($query);
    return new User($nickname);
  }

  /**
   * @action met à jour le mail de l'utilisateur si newMail est différent de null
   * @return true si tout va bien, false s'il y a eu une erreur au moment de la requete sql.
   */
  private static function updateMailIfNeeded($nickname, $newMail) {
    if(!empty($newMail)) {
      $db = DbManager::getPDO();
      $query = "UPDATE User SET email = '".$newMail."' WHERE nickname = '".$nickname."'";
      return $db->query($query);
    }
    return true;
  }

  /**
   * @action met à jour le password de l'utilisateur si possible
   * @return true si tout va bien, false si erreur sql ou newPassword !== confirmNewPassword
   */
  private static function updatePasswordIfNeeded($nickname, $newPassword, $confirmNewPassword) {
    if(!empty($newPassword) && !empty($confirmNewPassword)) {
      if($newPassword === $confirmNewPassword) {
        $db = DbManager::getPDO();
        $query = "UPDATE User SET password = '".$newPassword."' WHERE nickname = '".$nickname."'";
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
  private static function updatePhoneIfNeeded($nickname, $newPhone) {
    if(!empty($newPhone)) {
      $db = DbManager::getPDO();
      $query = "UPDATE User SET phone = '".$newPhone."' WHERE nickname = '".$nickname."'";
      return $db->query($query);
    } else {
      return true;
    }
  }

  /**
   * @action met à jour le firstname de l'utilisateur si newFirstname est différent de null
   * @return true si tout va bien, false s'il y a eu une erreur au moment de la requete sql.
   */
  private static function updateFirstnameIfNeeded($nickname, $newFirstname) {
    if(!empty($newFirstname)) {
      $db = DbManager::getPDO();
      $query = "UPDATE User SET firstname = '".$newFirstname."' WHERE nickname = '".$nickname."'";
      return $db->query($query);
    } else {
      return true;
    }
  }

  /**
   * @action met à jour le lastname de l'utilisateur si newLastname est différent de null
   * @return true si tout va bien, false s'il y a eu une erreur au moment de la requete sql.
   */
  private static function updateLastnameIfNeeded($nickname, $newLastname) {
    if(!empty($newLastname)) {
      $db = DbManager::getPDO();
      $query = "UPDATE User SET lastname = '".$newLastname."' WHERE nickname = '".$nickname."'";
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
  public static function updateProfile($nickname, $newPassword, $confirmNewPassword, $newMail, $newPhone, $newFirstname, $newLastname) {
    if(User::isUserExistInDataBase($nickname)) {
      return User::updateMailIfNeeded($nickname, $newMail)
          && User::updatePasswordIfNeeded($nickname, $newPassword, $confirmNewPassword)
          && User::updatePhoneIfNeeded($nickname, $newPhone)
          && User::updateFirstnameIfNeeded($nickname, $newFirstname)
          && User::updateLastnameIfNeeded($nickname, $newLastname);
    } else {
      return "Unknown nickname";
    }
  }

  /**
   * @return true si la suppression c'est bien passée, false sinon.
   */
  public static function deleteUser($nickname) {
      $db = DbManager::getPDO();
      $query = "DELETE FROM User WHERE nickname = '".$nickname."'";
      return $db->query($query);
  }



  public static function followAnimal($nickname, $idAnimal) {
    if(User::isUserExistInDataBase($nickname)) {
      if(Animal::isAnimalExistInDataBase($idAnimal)) {
        $db = DbManager::getPDO();
        $user = new User($nickname);
        $query = "INSERT INTO FollowAnimal(idUser, idAnimal) VALUES (".$user->nickname.",".$idAnimal.")";
        return ($db->exec($query)>=0);
      } else {
        return "Unknown animal";
      }
    } else {
      return "Unknown user";
    }
  }
}
?>
