<?php

require_once 'models/Shelter.php';

$shelter = new Shelter($_POST['idShelter']);
$messagesAboutShelter = $shelter->getMessages();
$messagesAboutAnimals = $shelter->getMessagesAboutAnimals();

echo json_encode(['messagesAboutShelter' => $messagesAboutShelter, 'messagesAboutAnimals' => $messagesAboutAnimals]);
