<?php
  require_once 'models/User.php';
  require_once 'tools/arrayOperation.php';

  $user = new User($_POST['nickname']);
  $listFollowedAnimals = $user->getFollowedAnimals();
  $preferences = $user->getPetsPreferences();
  $listCorrespondingAnimalsToAdopt = Animal::getHomelessAnimals($preferences['idType'], $preferences['catsFriend'], $preferences['dogsFriend'], $preferences['childrenFriend']);

  $randAnimalsCorresponding = getRandomNbElements($listCorrespondingAnimalsToAdopt, $_POST['numberOfAnimals']);
  $randAnimalsCorrespondingToSend = $user->setFollowedAnimals($randAnimalsCorresponding);

  echo json_encode(['followedAnimals' => $listFollowedAnimals, 'suggestedAnimals' => $randAnimalsCorrespondingToSend] );
