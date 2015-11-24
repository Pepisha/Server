<?php

require_once 'models/Shelter.php';

$listAnimals = Shelter::getSheltersAnimals();

echo json_encode($listAnimals);
