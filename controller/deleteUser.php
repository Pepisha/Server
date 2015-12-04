<?php

require_once 'models/User.php';

$user = new User($_POST['nickname']);
$deleteResult = $user->delete();
echo json_encode(['success' => $deleteResult]);
