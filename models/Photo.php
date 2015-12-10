<?php
  class Photo {
    private $idPhoto;
    private $name;
    private $description;
    private $idSubject;
    private $idSubjectType;

    public function __construct($idPhoto) {
      $db = DbManager::getPDO();
      $query = "SELECT * FROM Photo WHERE idPhoto = ".$idPhoto."";
      $res = $db->query($query)->fetch();
      $this->idPhoto = $res['idPhoto'];
      $this->name = $res['name'];
      $this->description = $res['description'];
      $this->idSubject = $res['idSubject'];
      $this->idSubjectType = $res['idSubjectType'];
    }

    public static function addPhotoInDataBase($name, $description, $idSubject, $idSubjectType) {
      $db = DbManager::getPDO();
      $query = "INSERT INTO Photo(name, description, idSubject, idSubjectType)
                VALUES ('".$name."','".$description."',".$idSubject.",".$idSubjectType.")";
      return $db->exec($query) > 0;
    }
  }

?>
