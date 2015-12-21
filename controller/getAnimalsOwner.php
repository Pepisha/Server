<?php
require_once 'models/Animal.php';

$ownerNickname = Animal::getAnimalsOwner($_POST['idAnimal']);

echo json_encode(['nickname' => $ownerNickname]);
