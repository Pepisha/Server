<?php

require_once 'models/User.php';

if(!empty($_POST['nickname'])) {
  $user = new User($_POST['nickname']);
  $updateResult = $user->updateProfile($_POST['newPassword'], $_POST['confirmNewPassword'],
  $_POST['newMail'], $_POST['newPhone'], $_POST['newFirstname'], $_POST['newLastname']);
  if(gettype($updateResult)==="string") {
    $result = ["success" => false, "error" => $updateResult];
  } else {
    $result = ["success" => true];
  }
} else {
  $result = ["success" => false, "error" => "Empty nickname"];
}

echo json_encode($result);
