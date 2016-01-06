<?php
  require_once 'models/User.php';

  $user = new User($_POST['nickname']);
  $animalToSend = $user->getAnimalCorrespondingToUserPreferences();

  echo json_encode(["animal" => $animalToSend]);
