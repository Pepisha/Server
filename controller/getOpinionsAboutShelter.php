<?php

require_once 'models/Opinion.php';

$listOpinions = Opinion::getOpinionsAboutShelter($_POST['idShelter']);

echo json_encode($listOpinions);
