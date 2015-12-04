<?php

require_once 'models/Animal.php';

$animal = new Animal($_POST['idAnimal']);
$updateStatus = $animal->updateStatus($_POST['newStatus']);
if(gettype($updateStatus)==="string") {
  $result = ['success' => false, 'error' => $updateStatus];
} else {
  $result = ['success' => $updateStatus];
}
echo json_encode($result);
