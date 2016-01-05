<?php

require_once 'models/User.php';
require_once 'models/Animal.php';
require_once 'models/Message.php';

$user = new User($_POST['nickname']);

if (isset($_POST['idAnimal'])) {
	$animal = new Animal($_POST['idAnimal']);
	$idShelter = $animal->getShelter();
	$idAnimal = $animal->getId();
} else {
	$idShelter = $_POST['idShelter'];
	$idAnimal = null;
}

$addingResult = $user->sendMessage(addslashes($_POST['content']), $idShelter, $idAnimal);

$result = ['success' => $addingResult];
echo json_encode($result);
