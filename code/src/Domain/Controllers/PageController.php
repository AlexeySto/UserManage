<?php

namespace Alexey\MyProdject\Domain\Controllers;

class PageController extends Controller {

    public function actionIndex(): string {
        return $this->render->renderPage('page-index.twig', ['title' => 'Главная страница']);
    }

    public function actionLogin(): string {
        return $this->render->renderPage('login.twig', ['title' => 'Вход']);
    }

    public function actionRegistration(): string {
        return $this->render->renderPage('registration.twig', ['title' => 'Регистрация', 'csrf_token' => random_bytes(8)]);
    }
}
