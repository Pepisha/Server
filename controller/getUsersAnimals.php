<?php

require_once 'models/User.php';

$listAnimals = User::getUsersAnimals($nickname);

echo json_encode($listAnimals);
