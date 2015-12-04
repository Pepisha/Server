<?php

require_once 'models/User.php';

$user = new User($_POST['nickname']);
$followResult = $user->unfollowAnimal($_POST['idAnimal']);

$result = ['success' => $followResult];

echo json_encode($result);
