<?php

require_once 'models/Animal.php';

$animal = new Animal($_POST['idAnimal']);
$messagesAboutAnimal = $animal->getMessages();

echo json_encode($messagesAboutAnimal);
