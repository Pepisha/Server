<?php


class User {

private $id;
private $nickname;
private $password;
private $mail;
private $phone;
private $firstname;
private $lastname;

  public function __construct($nickname){
    $db = DbManager::getPDO();
    $query = "SELECT * FROM User WHERE nickname = '".$nickname."'";
    $res = $db->query($query)->fetch();
    $this->id = $res['id'];
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
  public static function isUserExistInDataBase($nickname){
      $db = DbManager::getPDO();
      $query = "SELECT nickname FROM User WHERE nickname='".$nickname."';";
      $res = $db->query($query);
      $result=$res->fetch();
      return $result['nickname']===$nickname;
  }

  /**
   * @return true si le nickname et le password sont bons, false sinon.
   */
  public static function canUserLogin($nickaname, $password){
      $db = DbManager::getPDO();
      $query = "SELECT nickname FROM User WHERE nickname='".$nickname."' AND password='".$password."';";
      $result = $db->query($query)->fetch();
      return $result['nickname']===$nickname;
  }


  /**
   * @return null si l'utilisateur n'a pas pu être créé. L'utilisateur sinon.
   */
  public static function registerIfPossible($nickname, $password1, $password2, $mail, $phone, $firstname, $lastname){
    if(!empty($nickname) && !empty($password1) && !empty($password2)
      && !empty($mail) && !empty($phone) && !empty($firstname) && !empty($lastname)){
      if($password1===$password2){
        if(!isUserExistInDataBase($nickname)){
          return addUserInDataBase($nickname, $password1, $mail, $phone, $firstname, $lastname);
        } else {
          return "User already exist";
        }
      } else{
        return "Passwords differents";
      }
    }
  }

  /**
   * @return l'utilisateur ajouté dans la BDD
   */
  public static function addUserInDataBase($nickname, $password, $mail, $phone, $firstname, $lastname){
    $db = DbManager::getPDO();
    $query="INSERT INTO User(nickname, password, mail, phone, firstname, lastname) VALUES"
            ."'".$nickname."','".$password."','".$mail."','"
            .$phone."','".$firstname."','".$lastname."';";
    $db->query($query);
    return new User($nickname);
  }
}
?>
