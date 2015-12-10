<?php
require_once 'dbManager/DbManager.php';
require 'tools/jsonManipulation.php';

if (isset($_FILES['uploadedfile'])) {
	include 'controller/uploadImage.php';
} elseif (!empty($_POST['page']) && is_file('controller/'.$_POST['page'].'.php')) {
    include 'controller/'.$_POST['page'].'.php';
} else {
    echo "error page not found : ".'controller/'.$_POST['page'].'.php';
}
