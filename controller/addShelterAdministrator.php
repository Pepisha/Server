<?php

require_once 'models/Shelter.php';

$shelter = new Shelter($_POST['idShelter']);
$user = new User($_POST['nickname']);
$result = $shelter->addAdministrator($user->getId());

echo json_encode(["success" => $result]);
