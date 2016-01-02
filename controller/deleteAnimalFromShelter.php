<?php
require_once 'models/Shelter.php';
require_once 'models/User.php';

$user = new User($_POST['nickname']);
$shelter = new Shelter($_POST['idShelter']);
if ($user->isAdmin() || $shelter->isAdministrator($user->getId())) {
  $deleteAnimal = $shelter->deleteAnimal($_POST['idAnimal']);

  if (gettype($deleteAnimal) === "string") {
    $res = ['success' => false, 'error' => $deleteAnimal];
  } else {
    $res = ['success' => $deleteAnimal];
  }
} else {
  $res = ['success' => false, 'error' => 'Operation not allowed'];
}

echo json_encode($res);
