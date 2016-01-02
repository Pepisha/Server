<?php

require_once 'models/User.php';
require_once 'models/Animal.php';

$user = new User($_POST['nickname']);
$idType = (isset($_POST['idType'])) ? $_POST['idType'] : NULL;
$catsFriend = (isset($_POST['catsFriend'])) ? $_POST['catsFriend'] : NULL;
$dogsFriend = (isset($_POST['dogsFriend'])) ? $_POST['dogsFriend'] : NULL;
$childrenFriend = (isset($_POST['childrenFriend'])) ? $_POST['childrenFriend'] : NULL;


$listAnimals = Animal::getHomelessAnimals($idType, $catsFriend, $dogsFriend, $childrenFriend);
$result = $user->setFollowedAnimals($listAnimals);

echo json_encode($result);
