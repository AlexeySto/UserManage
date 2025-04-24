<?php

namespace Alexey\MyProdject\Application;

use Alexey\MyProdject\Domain\Models\DBHandler;
use Alexey\MyProdject\Domain\Models\User;

class Auth {

    public static function proceedAuth(User $user): void {
        $_SESSION['user_id'] = (string)$user->getUserId();
        $_SESSION['user_name'] = $user->getUserName();
        $_SESSION['user_lastname'] = $user->getUserLastname();
        $_SESSION['user_birthday'] = $user->getUserBirthdayToString();
    }

    public static function restoreSession(): void {
        if (isset($_COOKIE['user_token'])) {
            $token = $_COOKIE['user_token']; // Получаем токен из cookie
            $user = DBHandler::getUserByToken($token);
            if ($user) {
                self::proceedAuth($user);
            }
        }
    }

    public static function endSession(): void {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }

        if (isset($_COOKIE['user_token'])) {
            $token = $_COOKIE['user_token'];
            self::setUserTokenCookie($token, -3600);
        }

        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_lastname']);
        unset($_SESSION['user_birthday']);

        if (headers_sent()) {
            echo "Невозможно изменить информацию о заголовке - заголовки уже отправлены.";
        } else {
            header("Location: /");
            exit();
        }
    }

    public static function setUserTokenCookie($token, $expiry = 3600) {
        if ($token !== null) {
            // Шифруем токен для безопасности
            $encryptedToken = base64_encode($token);

            // Устанавливаем cookie на заданный срок
            setcookie("user_token", $encryptedToken, time() + $expiry, "/");
        }
    }
}