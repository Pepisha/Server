<?php

require_once 'models/User.php';
require_once 'models/Shelter.php';

$user = new User($_POST['nickname']);
$shelter = new Shelter($_POST['idShelter']);
$listAnimals = $shelter->getAnimals($_POST['numberOfAnimals']);
$listAnimals = $user->setFollowedAnimals($listAnimals);

echo json_encode($listAnimals);
