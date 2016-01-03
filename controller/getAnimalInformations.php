<?php

require_once 'models/User.php';
require_once 'models/Animal.php';

$idAnimal = $_POST['idAnimal'];
$user = new User($_POST['nickname']);
$animal = new Animal($idAnimal);
$result = $animal->getInformations();

$listAnimals = $user->setFollowedAnimals(array($idAnimal => $result));
$result = $listAnimals[$idAnimal];

if (gettype($result)==="string") {
  $resultToSend = ['success' => false, 'error' => $result];
} else {
  $resultToSend = ['success' => true, 'animal' => $result];
}
echo json_encode($resultToSend);
