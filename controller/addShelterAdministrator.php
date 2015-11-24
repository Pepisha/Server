<?php

require_once 'models/Shelter.php';

$result = Shelter::addAdministrator($_POST['idShelter'],$_POST['nickname']);

echo json_encode(["success" => $result]);
