<?php

require_once 'models/Animal.php';

$animal = new Animal($_POST['idAnimal']);
$setResult = $animal->setFavorite($_POST['favorite']);

$result = ['success' => $setResult];
echo json_encode($result);
