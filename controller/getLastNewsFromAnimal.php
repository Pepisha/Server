<?php

  require_once 'models/News.php';

  $lastNews = News::getLastNewsFromAnimal($_POST['idAnimal']);

  echo json_encode([$lastNews['idNews'] => $lastNews]);
