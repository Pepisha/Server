<?php

require_once 'models/User.php';
require_once 'models/Shelter.php';

$user = new User($_POST['nickname']);
$shelter = new Shelter($_POST['idShelter']);
$listAdoptedAnimals = $shelter->getAdoptedAnimals();
$listAnimals = $user->setFollowedAnimals($listAnimals);

echo json_encode($listAdoptedAnimals);
