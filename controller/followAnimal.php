<?php

require_once 'models/User.php';

$followResult = User::followAnimal($_POST['nickname'],$_POST['idAnimal']);
if(gettype($followResult)==="string") {
  $result = ['success' => false, 'error' => $followResult];
} else {
  $result = ['success' => $followResult];
}
echo json_encode($result);
