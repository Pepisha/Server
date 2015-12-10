<?php

require_once 'models/Shelter.php';

$shelter = new Shelter($_POST['idShelter']);
$result = $shelter->getInformations();
if(gettype($result)==="string") {
  $resultToSend = ['success' => false, 'error' => $result];
} else {
  $resultToSend = ['success' => true, $result['idShelter'] => $result];
}
echo json_encode($resultToSend);
