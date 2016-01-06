<?php

require_once 'models/User.php';

$user = new User($_POST['nickname']);
$catsFriend = (isset($_POST['catsFriend'])) ? $_POST['catsFriend'] : NULL;
$dogsFriend = (isset($_POST['dogsFriend'])) ? $_POST['dogsFriend'] : NULL;
$childrenFriend = (isset($_POST['childrenFriend'])) ? $_POST['childrenFriend'] : NULL;
$idType = (isset($_POST['idType'])) ? $_POST['idType'] : NULL;

$setResult = $user->setPetsPreferences($catsFriend, $dogsFriend, $childrenFriend, $idType);
$user->changeAnimalUserPreferences($catsFriend, $dogsFriend, $childrenFriend, $idType);

$result = ['success' => $setResult];
echo json_encode($result);
