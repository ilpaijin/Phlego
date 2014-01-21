<?php

use Phlego\Views\Template;
use Phlego\Views\Partial;

define('DS', DIRECTORY_SEPARATOR);

require_once "vendor/autoload.php";

$view = new Template(NULL, array(
    "intro" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quae, laboriosam, molestiae, eveniet esse impedit vero expedita ratione nobis saepe minima fugiat provident architecto cum consectetur delectus odit ad. At, nobis.", 
    "title" => "Phlego", 
    'leftContent' => 'Left content here',
    'rightContent' => 'Right content here'
));

echo $view->render();