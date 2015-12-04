<?php

require_once 'models/Shelter.php';

$shelter = new Shelter($_POST['idShelter']);
$listAnimals = $shelter->getAnimals();

echo json_encode($listAnimals);
