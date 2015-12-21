<?php
require_once 'models/User.php';

$user = new User($_POST['nickname']);
$isUserAnimalsOwner = $user->isUserAnimalsOwner($_POST['idAnimal']);

echo json_encode(['owner' => $isUserAnimalsOwner]);
