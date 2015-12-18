<?php

class News {
  private $idNews;
  private $description;
  private $idAnimal;
  private $dateNews;

  public function __construct($idNews) {
    $db = DbManager::getPDO();
    $query = "SELECT * FROM News WHERE idNews = ".$idNews;
    $res = $db->query($query)->fetch();

    $this->idNews = $res['idNews'];
    $this->description = $res['description'];
    $this->idAnimal = $res['idAnimal'];
    $this->date = $res['$dateNews'];
  }

  public static function getLastNewsFromAnimal($idAnimal) {
    $db = DbManager::getPDO();
    $query = "SELECT idNews, description, idAnimal, MAX($dateNews) FROM News WHERE idAnimal = ".$idAnimal;
    $res = $db->query($query)->fetch();

    return News::getNewsArrayFromFetch($res);
  }

  public static function addNewsInDataBase($description, $idAnimal) {
    if(Animal::isAnimalExistInDataBase($idAnimal)) {
      $db = DbManager::getPDO();
      $query = "INSERT INTO News(description, idAnimal, dateNews)
                VALUES ('".$description."', ".$idAnimal.", NOW())";
      return ($db->exec($query)>=0);
    } else {
      return "Unknown animal";
    }
  }

  private static function getNewsArrayFromFetch($news) {
    $newsArray['idNews'] = intval($opinion['idNews']);
    $newsArray['description'] = $opinion['description'];
    $newsArray['idAnimal'] = $opinion['idAnimal'];
    $newsArray['dateNews'] = $opinion['dateNews'];
    return $newsArray;
  }

  public static function getAnimalsNews($idAnimal) {
    $db = DbManager::getPDO();
    $query = "SELECT * FROM News WHERE idAnimal = ".$idAnimal;
    $res = $db->query($query)->fetchAll();

    for($i = 0; $i < count($res), $i++) {
      $news = News::getNewsArrayFromFetch($res[$i]);
      $listNews[$news['idNews']] = $news;
    }

    return $news;
  }
}
