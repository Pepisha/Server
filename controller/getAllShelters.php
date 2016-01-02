<?php

require_once 'models/User.php';
require_once 'models/Shelter.php';

$user = new User($_POST['nickname']);
$listShelters = Shelter::getAllShelters();
$result = $user->setFollowedShelters($listShelters);

echo json_encode($result);
