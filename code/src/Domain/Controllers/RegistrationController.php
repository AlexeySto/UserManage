<?php

namespace Alexey\MyProdject\Domain\Controllers;

use Alexey\MyProdject\Domain\Models\DBHandler;
use Alexey\MyProdject\Domain\Controllers\UserController;
use Alexey\MyProdject\Application\Validator;

class RegistrationController extends AbstractController {
    public function actionSave(): string {
        $registration_rules = [
            'name' => ['required', 'no_html'],
            'lastname' => ['required', 'no_html'],
            'email'=> ['required', 'no_html', 'valid_email'],
            'birthday' => ['required', 'no_html', 'valid_birthday'],
            'password' => ['required', 'no_html'],
        ];
        $errors = Validator::validate_data($_POST, $registration_rules);
  

        if (empty($errors)) {
            $res = DBHandler::saveToStorage(user: UserController::getUser(), email: $_POST['email'],
                password_hash: self::getPasswordHash($_POST['password']),
                csrf_token: $_POST['csrf_token']);
                
            if ($res) {
                return $this->render->renderPage();
            } else {
                return $this->render->renderPage(
                    'registration.twig',
                    [
                        'title' => 'Ошибка при регистрации.',
                        'csrf_token' => random_bytes(8), 
                        'errors' => 'Ошибка при регистрации, возможно пользователь с таким email уже зарегистрирован.'
                    ]);
            }
        }
        else {
            return $this->render->renderPage(
                'registration.twig',
                [
                    'title' => 'Введены не корректные данные.',
                    'csrf_token' => random_bytes(8), 
                    'errors' => $errors
                ]);
        }
    }

    private static function getPasswordHash(string $password): string {
        return password_hash($password, PASSWORD_BCRYPT);
    }
}