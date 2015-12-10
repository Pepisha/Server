<?php

require_once 'models/User.php';

$user = new User($_POST['nickname']);
$listShelters = $user->getFollowedShelters();

echo json_encode($listShelters);
