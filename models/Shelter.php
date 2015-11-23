<?php
require_once 'models/Address.php';

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
}


 ?>
