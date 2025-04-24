<?php

namespace Alexey\MyProdject\Domain\Controllers;

use Alexey\MyProdject\Domain\Models\DBHandler;

class UserController extends AbstractController {

    protected array $actionsPermissions = [
        'actionUpdate' => ['admin'],
        'actionDelete' => ['admin'],
    ];

    public function actionIndex(): string {
        $users = DBHandler::getAllUsersFromStorage();
        $title = 'Список пользователей в хранилище';

        if(!$users){
            return $this->render->renderPage(
                'user-empty.twig',
                [
                    'title' => $title,
                    'message' => "Список пуст или не найден"
                ]);
        }
        else{
            $pattern = (in_array('admin', self::getUserRules()))
                         ? 'user-index-admin.twig' : 'user-index.twig';
            return $this->render->renderPage(
                $pattern,
                [
                    'title' => $title,
                    'users' => $users
                ]);
        }
    }
    public function actionIndexRefresh(): string {
        $limit = filter_input(INPUT_POST, 'maxId', FILTER_VALIDATE_INT);
        // Проверка, действительно ли задан лимит
        if ($limit === false || $limit <= 0) {
            $limit = null;
        }
    
        $users = DBHandler::getAllUsersFromStorage($limit);
        $usersData = [];
    
        if (count($users) > 0) {
            foreach ($users as $user) {
                $usersData[] = ['id' => $user->getUserId(),
                    'username' => $user->getUserName(), 
                    'userlastname' => $user->getUserLastname(),
                    'userbirthday' => $user->getUserBirthdayToString()
                    ];
            }
        }
    
        return json_encode($usersData);  
    }
    
    public function actionUpdateInfo(): string {
        $user =self::getUser();

        return $this->render->renderPage(
            'update.twig',
            [
                'title' => 'Изменение данных пользователя',
                'user' => $user
            ]);
    }

    public function actionUpdate(): string {
        return self::action("update");
    }

    public function actionDelete(): string {
        return self::action("delete");
    }

    private function action(string $actionName): string {
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            if($actionName == "update") DBHandler::updateToStorage($_POST['id'], self::getUser()); 
            if($actionName == "delete") DBHandler::deleteFromStorage($_POST['id']); 
        }
        else {
            throw new \Exception("ID не указан");
            
        }
        return self::actionIndex();
    }

    public function getUserRules(): array{
        $rules[] = 'user';
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            $rules = DBHandler::getUserRules($_SESSION['user_id']);
        }  
        return $rules;
    }

    public function actionNotRules(): string {
        return $this->render->renderPage('error.twig', ['title' => 'Нет прав', 'error_message' => 'У Вас нет прав для выполнения этого действия.']);
    }
}
