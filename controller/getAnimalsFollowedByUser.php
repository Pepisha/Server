<?php

require_once 'models/User.php';

$user = new User($_POST['nickname']);
$listAnimals = $user->getFollowedAnimals();

echo json_encode($listAnimals);
