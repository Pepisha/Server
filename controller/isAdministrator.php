<?php

require_once 'models/User.php';

$user = new User($_POST['nickname']);
$isAdmin = $user->isAdmin();

$result = ['admin' => $isAdmin];

echo json_encode($result);
