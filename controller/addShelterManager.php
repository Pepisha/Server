<?php

require_once 'models/Shelter.php';

$result = Shelter::addManager($_POST['idShelter'],$_POST['nickname']);

echo json_encode(["success" => $result]);
