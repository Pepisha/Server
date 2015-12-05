<?php

require_once 'models/Shelter.php';

$shelter = new Shelter($_POST['idShelter']);
$user = new User($_POST['nickname']);
$manager = $shelter->isManager($user->getId());

$result = ['manager' => $manager];

echo json_encode($result);
