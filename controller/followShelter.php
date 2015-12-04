<?php

require_once 'models/User.php';

$user = new User($_POST['nickname']);
$followResult = $user->followShelter($_POST['idShelter']);
if(gettype($followResult)==="string") {
  $result = ['success' => false, 'error' => $followResult];
} else {
  $result = ['success' => $followResult];
}
echo json_encode($result);
