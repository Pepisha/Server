<?php

require_once 'models/User.php';

$user = new User($_POST['nickname']);
$following = $user->isFollowingAnimal($_POST['idAnimal']);

$result = ['following' => $following];

echo json_encode($result);
