<?php

require_once 'models/User.php';

$user = new User($_POST['nickname']);
$user->haveSeenAnimal($_POST['idAnimal']);
