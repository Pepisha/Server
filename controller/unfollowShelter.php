<?php

require_once 'models/User.php';

$user = new User($_POST['nickname']);
$followResult = $user->unfollowShelter($_POST['idShelter']);

$result = ['success' => $followResult];

echo json_encode($result);
