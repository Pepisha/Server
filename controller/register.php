<?php

require_once 'models/User.php';

$user = User::registerIfPossible($_POST['nickname'],$_POST['password1'],$_POST['password2'],
                       $_POST['mail'], $_POST['phone'], $_POST['firstname'],
                       $_POST['lastname']);
if($user.gettype()==="string"){ //Il y a eu une erreur à la création
  $response = ['success' => false, 'error' => $user];
}
else{
  $response = ['success' => true];
}

jsonEncode($response);