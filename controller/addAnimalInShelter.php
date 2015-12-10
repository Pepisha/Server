<?php

require_once 'models/Shelter.php';

$shelter = new Shelter($_POST['idShelter']);
$addResult = $shelter->addAnimal($_POST['type'], $_POST['name'], $_POST['breed'], $_POST['age'], $_POST['gender'], $_POST['catsFriend'],
									$_POST['dogsFriend'], $_POST['childrenFriend'], $_POST['description']);

if(gettype($addResult) === "string") {
  $response = ['success' => false, 'error' => $addResult];
} else {
  $response = ['success' => true];
}

echo json_encode($response);
