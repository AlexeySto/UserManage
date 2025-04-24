<?php

namespace Alexey\MyProdject\Domain\Controllers;

use Alexey\MyProdject\Domain\Models\Phone;
use Alexey\MyProdject\Application\Render;

class AboutController extends Controller {

    public function actionIndex(): string {
        return $this->render->renderPage('about.twig');
    }
}
