<?php

require_once 'models/News.php';

$listNews = News::getAnimalsNews($_POST['idAnimal']);

echo json_encode($listNews);
