<?php

namespace Alexey\MyProdject\Domain\Controllers;
use Alexey\MyProdject\Application\Render;
use Alexey\MyProdject\Domain\Models\User;

class Controller {

    protected Render $render;

    public function __construct() {
        $this->render = new Render();
    }

    public static function getUser(): User {
        $user_id = self::getArg(arg: 'id');
        $user_name = self::getArg(arg: 'name');
        $user_lastname = self::getArg(arg: 'lastname');
        $user_birthday = self::getArg(arg: 'birthday');

        return new User(user_id: $user_id, name: $user_name, lastname: $user_lastname, birthday: $user_birthday);
    }

    private static function getArg(string $arg): string|null {
        return (isset($_POST[$arg]) && !empty($_POST[$arg])) ? $_POST[$arg] : null;
    }

}