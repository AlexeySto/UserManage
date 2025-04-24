<?php

namespace Alexey\MyProdject\Domain\Controllers;

use Alexey\MyProdject\Domain\Models\DBHandler;
use Alexey\MyProdject\Application\Auth;
use Alexey\MyProdject\Application\Validator;

class AuthController extends AbstractController {

    public function actionLogin(): string {
        $registration_rules = [
            'email'=> ['required', 'no_html', 'valid_email'],
            'password' => ['required', 'no_html'],
        ];
        $errors = Validator::validate_data($_POST, $registration_rules);

        if (empty($errors)) {
            $newUser = DBHandler::getUserByEmailAndPassword($_POST['email'], $_POST['password']);

            if($newUser) {
                if((isset($_POST['remember']) && $_POST['remember'] == "remember")) {
                    $token = DBHandler::getUserToken($newUser->getUserId());
                    Auth::setUserTokenCookie($token);
                }
                Auth::proceedAuth($newUser);
                return $this->render->renderPage();
            }
            else {
                return $this->render->renderPage(
                    'login.twig');
            }  
        } 
        else {
            return $this->render->renderPage(
                'login.twig',
                ['title' => 'Введены не корректные данные.',
                 'errors' => $errors]);
        }
    }
    
    public function actionLogout(): void {
        Auth::endSession();
    }
}