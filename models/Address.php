<?php

public class Address {
  private $idAddress;
  private $street;
  private $zipcode;
  private $city;
  private $latitude;
  private $longitude;

  public static function addAddress($street, $zipcode, $city, $latitude, $longitude) {
    $db = DbManager::getPDO();
    $query = "INSERT INTO Address(street, zipcode, city, latitude, longitude)
              VALUES ('".$street."','".$zipcode."','".$city."','".$latitude."','".$longitude."')";
    $db->exec($query);

    $query = "SELECT idAddress FROM Address WHERE street = '".$street."', zipcode = '".$zipcode."', city = '".$city."';";
    $res = $db->query($query)->fetch();
    return $res['idAddress'];
  }
}

 ?>
