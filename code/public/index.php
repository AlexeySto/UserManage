<?php

require_once('../vendor/autoload.php');

use Alexey\MyProdject\Application\Application;
use Alexey\MyProdject\Application\Render;

try{
    $app = new Application();
    echo $app->runApp();
}
catch(Exception $e){
    $render = new Render();
    echo $render->renderPage('error.twig', ['title' => 'Ошибка', 'error_message' => $e]);
}
