<?php

require_once 'models/Opinion.php';

$user = new User($_POST['nickname']);
$result = Opinion::addOpinionInDataBase($_POST['stars'], $_POST['description'], $user->getId(), $_POST['idShelter']);

if(gettype($result) === "string") {
  $response = ['success' => false, 'error' => $result];
} else {
  $response = ['success' => $result];
}

echo json_encode($response);
