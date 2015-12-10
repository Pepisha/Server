<?php

require_once 'dbManager/DbManager.php';
require 'tools/jsonManipulation.php';

if (!empty($_POST['page']) && is_file('controller/'.$_POST['page'].'.php')) {
    include 'controller/'.$_POST['page'].'.php';
} else {
    echo "error page not found : ".'controller/'.$_POST['page'].'.php';
}
