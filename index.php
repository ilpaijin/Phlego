<?php

use Phlego\Views\Template;
use Phlego\Views\Partial;

define('DS', DIRECTORY_SEPARATOR);

require_once "vendor/autoload.php";

$view = new Template(NULL, array("myVar" => "myVariable"));

// $view->addView(new Partial('header'));
// $view->addView(new Partial('body'));
// $view->addView(new Partial('footer'));

echo $view->render();