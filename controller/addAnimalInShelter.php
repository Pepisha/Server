<?php

require_once 'models/Shelter.php';

$shelter = new Shelter($_POST['idShelter']);
$addResult = $shelter->addAnimal($_POST['idAnimal']);

if(gettype($addResult) === "string") {
  $response = ['success' => false, 'error' => $addResult];
} else {
  $response = ['success' => $addResult];
}

echo json_encode($response);
