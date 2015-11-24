<?php

require_once 'models/Shelter.php';

$listShelters = Shelter::getAllShelters();

echo json_encode($listShelters);
