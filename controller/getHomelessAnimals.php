<?php

require_once 'models/User.php';
require_once 'models/Animal.php';

$user = new User($_POST['nickname']);
$catsFriend = (isset($_POST['catsFriend'])) ? $_POST['catsFriend'] : NULL;
$dogsFriend = (isset($_POST['dogsFriend'])) ? $_POST['dogsFriend'] : NULL;
$childrenFriend = (isset($_POST['childrenFriend'])) ? $_POST['childrenFriend'] : NULL;


$listAnimals = Animal::getHomelessAnimals($catsFriend, $dogsFriend, $childrenFriend);
$listAnimals = $user->setFollowedAnimals($listAnimals);

echo json_encode($listAnimals);
