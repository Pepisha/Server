<?php

require_once 'models/User.php';

$listUsers = User::getAllUsers();

echo json_encode($listUsers);
