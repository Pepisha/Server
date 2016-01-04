<?php

require_once 'models/Message.php';

$message = new Message($_POST['idMessage']);
$message->setRead();
