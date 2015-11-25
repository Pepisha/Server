<?php

require_once 'models/User.php';

$followResult = User::followShelter($_POST['nickname'],$_POST['idShelter']);
if(gettype($followResult)==="string") {
  $result = ['success' => false, 'error' => $followResult];
} else {
  $result = ['success' => $followResult];
}
echo json_encode($result);
