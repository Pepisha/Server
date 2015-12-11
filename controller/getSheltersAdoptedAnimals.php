<?php

require_once 'models/Shelter.php';

$shelter = new Shelter($_POST['idShelter']);
$listAdoptedAnimals = $shelter->getAdoptedAnimals();

echo json_encode($listAdoptedAnimals);
