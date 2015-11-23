<?php
  class Animal {
    private $idAnimal;
    private $type;
    private $name;
    private $breed;
    private $age;
    private $gender;
    private $catsFriend;
    private $dogsFriend;
    private $childrenFriend;
    private $description;
    private $state;

    public function __construct($idAnimal) {
      $db = DbManager::getPDO();
      $query = "SELECT * FROM Animal WHERE idAnimal = ".$idAnimal."";
      $res = $db->query($query)->fetch();
      $this->idAnimal = $res['idAnimal'];
      $this->type = $res['type'];
      $this->name = $res['name'];
      $this->breed = $res['breed'];
      $this->age = $res['age'];
      $this->gender = $res['gender'];
      $this->catsFriend = $res['catsFriend'];
      $this->dogsFriend = $res['dogsFriend'];
      $this->childrenFriend = $res['childrenFriend'];
      $this->description = $res['description'];
      $this->state = $res['state'];
    }

    public static function isAnimalExistInDataBase($idAnimal) {
      $db = DbManager::getPDO();
      $query = "SELECT idAnimal FROM Animal WHERE idAnimal='".$idAnimal."';";
      $res = $db->query($query)->fetch();
      return $result['idAnimal'] === $idAnimal;
    }

    public static function addAnimalInDataBase($type, $name, $breed, $age, $gender, $catsFriend, $dogsFriend,
    $childrenFriend, $description, $state) {
      $db = DbManager::getPDO();
      $query = "INSERT INTO Animal(type, name, breed, age, gender, catsFriend, dogsFriend, childrenFriend, description, state)
                VALUES (".$type.",'".$name."','".$breed."','".$age."','".$gender."','".$catsFriend."','".$dogsFriend."','".$childrenFriend."',
                '".$description."',".$state.");";
      return $db->exec($query);
    }

    public static function updateStatus($idAnimal, $newStatus) {
      if(Animal::isAnimalExistInDataBase($idAnimal)) {
        $db = DbManager::getPDO();
        $query = "UPDATE Animal SET status = ".$newStatus." WHERE idAnimal = ".$idAnimal.";";
        return $db->query($query);
      } else {
        return "Unknown animal";
      }
    }
  }



 ?>
