<?php

require_once 'models/Shelter.php';

$addResult = Shelter::addAnimalInShelter($_POST['idShelter'], $_POST['type'], $_POST['name'], $_POST['breed'], $_POST['age'], $_POST['gender'], $_POST['catsFriend'],
                                         $_POST['dogsFriend'], $_POST['childrenFriend'], $_POST['description'], $_POST['state']);

if(gettype($addResult) === "string") {
  $response = ['success' => false, 'error' => $addResult];
} else {
  $response = ['success' => $addResult];
}

echo json_encode($response);
