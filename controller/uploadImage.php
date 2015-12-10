<?php

$target_path = "./images/";
$target_path = $target_path . basename($_FILES['uploadedfile']['name']);

$uploadResult = move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path);
$result = ['success' => $uploadResult];

echo json_encode($result);
