<?php

require_once 'models/User.php';

$deleteResult = User::delete($_POST['nickname']);
echo json_encode(['success' => $deleteResult]);
