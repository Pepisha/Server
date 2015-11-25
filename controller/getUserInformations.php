<?php

require_once 'models/User.php';

$result = User::followShelter($_POST['nickname'],$_POST['idShelter']);
if(gettype($result)==="string") {
  $resultToSend = ['success' => false, 'error' => $result];
} else {
  $resultToSend = ['success' => true, $result['nickname'] => $result];
}
echo json_encode($resultToSend);
