<?php

require_once 'models/Animal.php';

$result = Animal::getAnimalInformations($_POST['idAnimal']);
if(gettype($result)==="string") {
  $resultToSend = ['success' => false, 'error' => $result];
} else {
  $resultToSend = ['success' => true, $result['idAnimal'] => $result];
}
echo json_encode($resultToSend);
