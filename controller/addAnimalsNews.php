<?php

require_once 'models/News.php';

$addResult = News::addNewsInDataBase($_POST['description'], $_POST['idAnimal']);

if(gettype($addResult) === "string") {
  $response = ['success' => false, 'error' => $addResult];
} else {
  $response = ['success' => true];
}

echo json_encode($response);
