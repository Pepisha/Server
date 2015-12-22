<?php

require_once 'models/User.php';

$user = new User($_POST['nickname']);
$setResult =  $user->setInterestedOnAnimal($_POST['idAnimal']);

$result = ['success' => $setResult];
echo json_encode($result);
