<?php

namespace Alexey\MyProdject\Domain\Controllers;

class ErrorController  extends Controller {

    public function actionIndex(): string {
        header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
        return $this->render->renderError('404.twig');
    }
}
