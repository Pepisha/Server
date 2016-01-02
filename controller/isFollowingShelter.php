<?php

require_once 'models/User.php';

$user = new User($_POST['nickname']);
$following = $user->isFollowingShelter($_POST['idShelter']);

$result = ['following' => $following];

echo json_encode($result);
