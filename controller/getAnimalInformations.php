<?php

require_once 'models/Animal.php';

$animal = new Animal($_POST['idAnimal']);
$result = $animal->getInformations();
if(gettype($result)==="string") {
  $resultToSend = ['success' => false, 'error' => $result];
} else {
  $resultToSend = ['success' => true, $result['idAnimal'] => $result];
}
echo json_encode($resultToSend);
