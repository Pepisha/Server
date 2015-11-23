<?php

require_once 'models/Animal.php';

$updateStatus = Animal::updateStatus($_POST['idAnimal'],$_POST['newStatus']);
if(gettype($updateStatus)==="string") {
  $result = ['success' => false, 'error' => $updateStatus];
} else {
  $result = ['success' => $updateStatus];
}
echo json_encode($result);
