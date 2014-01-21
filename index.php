<?php

use Phlego\Views\Template;
use Phlego\Views\Partial;

define('DS', DIRECTORY_SEPARATOR);

require_once "vendor/autoload.php";

$view = new Template(NULL, array("myVar" => "myVariable", "title" => "Phlego"));

echo $view->render();