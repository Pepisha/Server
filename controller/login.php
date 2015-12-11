<?php

require_once 'models/User.php';

$nickname = $_POST['nickname'];
$password = $_POST['password'];


if (!empty($nickname) && !empty($password)) {
    $connectionResult = User::canUserLogin($nickname, $password);
    $user = new User($nickname);
    $isAdmin =  boolval($user->getAdmin());
    echo json_encode(array("success" => $connectionResult, "isAdmin" =>$isAdmin));
}
else{
    echo json_encode(array("success" => false));
}
