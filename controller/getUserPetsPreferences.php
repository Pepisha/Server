<?php

require_once 'models/User.php';

$user = new User($_POST['nickname']);
$preferences = $user->getPetsPreferences();

echo json_encode($preferences);
