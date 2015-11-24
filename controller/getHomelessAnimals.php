<?php

require_once 'models/Animal.php';

$listAnimals = Animal::getHomelessAnimals();

echo json_encode($listAnimals);
