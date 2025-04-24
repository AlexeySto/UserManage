<?php

namespace Alexey\MyProdject\Domain\Models;

use Alexey\MyProdject\Application\Application;

class DBHandler {
   
    public static function saveToStorage(User $user, string $email, string $password_hash , string $csrf_token){
        $sql = "INSERT INTO users(user_name, user_lastname, email, user_birthday_timestamp, password_hash, csrf_token) 
            VALUES (:user_name, :user_lastname, :email, :user_birthday, :password_hash, :csrf_token)";
        try {
            return self::getHandler($sql, [
                'user_name' => $user->getUserName(),
                'user_lastname' => $user->getUserLastname(),
                'email'=> $email,
                'user_birthday' => $user->getUserBirthdayToTimestemp(),
                'password_hash' => $password_hash,
                'csrf_token' => $csrf_token
            ]);
        }
        catch (\Exception $e) {
            return false;
        }
    }

    public static function updateToStorage(int $id, User $user) : void{
        $sql = "UPDATE users SET user_name = :user_name, user_lastname = :user_lastname, user_birthday_timestamp = :user_birthday WHERE id_user = :id_user";

        self::getHandler($sql, [
            'id_user' => $id,
            'user_name' => $user->getUserName(),
            'user_lastname' => $user->getUserLastname(),
            'user_birthday' => $user->getUserBirthdayToTimestemp()
        ]);
    }

    public static function deleteFromStorage(int $user_id) : void {
        $sql = "DELETE FROM users WHERE id_user = :id_user";
        self::getHandler($sql,['id_user' => $user_id]);
    }

    public static function getAllUsersFromStorage(?int $limit = null): array {
        $sql = "SELECT * FROM users";

        if(isset($limit) && $limit > 0) {
            $sql .= " WHERE id_user > " .(int)$limit;
        }

        $result = self::getHandler($sql)->fetchAll();
        $users = [];

        foreach($result as $item){
            $user = new User( $item['id_user'],  $item['user_name'],  $item['user_lastname'], date('d-m-Y', $item['user_birthday_timestamp']));
            $users[] = $user;
        }
        
        return $users;
    }

    public static function getUserRules(int $user_id): array{
        $rules[] = 'user';

        if(isset($user_id)){
            $sql = "SELECT * FROM user_rules WHERE id_user = :id_user";
            $result = self::getHandler($sql,['id_user' => $user_id])->fetchAll();
    
            if(!empty($result)){
                foreach($result as $rule){
                    $rules[] = $rule['rule'];
                }
            }
        }

        return $rules;
    }

    public static function getUserToken(int $user_id): ?string {
        $sql = "SELECT csrf_token FROM users WHERE id_user = :id_user";
        $result = self::getHandler($sql, ['id_user' => $user_id])->fetch();
        return $result ? $result['csrf_token'] : null;
    }

    public static function getUserByEmailAndPassword(string $email, string $password): ?User {
        $sql = "SELECT id_user, user_name, user_lastname, user_birthday_timestamp, password_hash FROM users WHERE email = :email";

        $result = self::getHandler($sql, ['email' => $email])->fetch();

        if(!empty($result)){
            if(password_verify($password, $result['password_hash'])){
                return new User($result['id_user'], $result['user_name'],
                     $result['user_lastname'],
                      date('d-m-Y', $result['user_birthday_timestamp']));
            }
        }
        return null;
    }

    public static function getUserByToken(string $token): ?User {
        $sql = "SELECT id_user, user_name, user_lastname, user_birthday_timestamp, password_hash FROM users WHERE csrf_token = :csrf_token";

        $result = self::getHandler($sql,['csrf_token' => $token])->fetchAll();
        if (!empty($result)) {
            $userInfo = $result[0];
            return new User($userInfo['id_user'], $userInfo['user_name'], $userInfo['user_lastname'], date('d-m-Y', $userInfo['user_birthday_timestamp']));
        }

        return null;
    }

    private static function getHandler(string $sql, ?array $params = null) {
        $handler = Application::$storage->get()->prepare($sql);
        if (isset($params) && !empty($params)) {
            $handler->execute($params);
        } else {
            $handler->execute();
        }
        return $handler;
    }
}