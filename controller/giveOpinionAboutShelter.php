<?php

require_once 'models/Opinion.php';

$result = Opinion::addOpinion($_POST['stars'], $_POST['description'], $_POST['nickname'], $_POST['idShelter']);

if(gettype($result) === "string") {
  $response = ['success' => false, 'error' => $result];
} else {
  $response = ['success' => $result];
}

echo json_encode($response);
