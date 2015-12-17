<?php

require_once 'models/User.php';
require_once 'models/Animal.php';

$user = new User($_POST['nickname']);
$listAnimals = Animal::getHomelessAnimals();
$listAnimals = $user->setFollowedAnimals($listAnimals);

echo json_encode($listAnimals);
