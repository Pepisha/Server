<?php

require_once 'models/Message.php';
require_once 'models/Shelter.php';

$shelter = new Shelter($_POST['idShelter']);
$messages = $shelter->getMessages();

echo json_encode($messages);
