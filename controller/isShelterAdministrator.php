<?php

require_once 'models/Shelter.php';

$shelter = new Shelter($_POST['idShelter']);
$user = new User($_POST['nickname']);
$admin = $shelter->isAdministrator($user->getId());

$result = ['admin' => $admin];

echo json_encode($result);
