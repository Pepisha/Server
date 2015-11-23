<?php

require_once 'models/Shelter.php';

$addResult = Shelter::addShelter($_POST['name'], $_POST['phone'], $_POST['description'],
                                 $_POST['email'], $_POST['operationalHours'], $_POST['street'],
                                 $_POST['zipcode'], $_POST['city'], $_POST['latitude'], $_POST['longitude']);
echo json_encode(['success' => $addResult]);
