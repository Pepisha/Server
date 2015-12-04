<?php

require_once 'models/Opinion.php';

$shelter = new Shelter($_POST['idShelter']);
$listOpinions = $shelter->getOpinions();

echo json_encode($listOpinions);
