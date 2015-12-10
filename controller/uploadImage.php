<?php

require_once 'models/Photo.php';
require_once 'models/Animal.php';

$target_path = "./images/";
$animal = new Animal($_POST['animalId']);

$filepath = $_FILES['uploadedfile']['name'];
$extension = pathinfo($filepath, PATHINFO_EXTENSION);

$generatedFilename = uniqid($animal->getName() . "_");
$filepath = $generatedFilename . "." . $extension;
$target_path = $target_path . $filepath;

$result = move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path);

if ($result) {
	$result = $animal->addPhoto($filepath, $_POST['description']);
}

$result = ['success' => $result];

echo json_encode($result);
