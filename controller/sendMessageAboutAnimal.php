<?php

require_once 'models/User.php';
require_once 'models/Animal.php';
require_once 'models/Message.php';

$user = new User($_POST['nickname']);
$animal = new Animal($_POST['idAnimal']);

$setResult =  $user->setInterestedOnAnimal($_POST['idAnimal']);
if ($setResult) {
	$addingResult = $user->sendMessageToShelter(addslashes($_POST['content']), $animal->getShelter());
}

$result = ['success' => ($setResult && $addingResult)];
echo json_encode($result);
