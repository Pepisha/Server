<?php

require_once 'models/User.php';

$nickname = $_POST['nickname'];
$password = $_POST['password'];


if (!empty($nickname) && !empty($password)) {
    $connectionResult = User::canUserLogin($nickname, $password);
    echo json_encode(array("success" => $connectionResult));
}
else{
    echo json_encode(array("success" => false));
}