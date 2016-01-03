<?php

require_once 'models/Animal.php';

$animal = new Shelter($_POST['idAnimal']);
$messagesAboutAnimal = $animal->getMessages();

echo json_encode($messagesAboutAnimal);
