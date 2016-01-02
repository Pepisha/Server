<?php

require_once 'models/Shelter.php';

$idShelter = $_POST['idShelter'];
$shelter = new Shelter($idShelter);
$user = new User($_POST['nickname']);
$result = $shelter->getInformations();

$listShelters = $user->setFollowedShelters(array($idShelter => $result));
$result = $listShelters[$idShelter];

if (gettype($result)==="string") {
  $resultToSend = ['success' => false, 'error' => $result];
} else {
  $resultToSend = ['success' => true, "shelter" => $result];
}

echo json_encode($resultToSend);
