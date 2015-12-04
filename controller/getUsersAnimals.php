<?php

require_once 'models/User.php';

$user = new User($nickname);
$listAnimals = $user->getAnimals();

echo json_encode($listAnimals);
