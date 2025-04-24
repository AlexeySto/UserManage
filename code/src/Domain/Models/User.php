<?php

namespace Alexey\MyProdject\Domain\Models;

use Alexey\MyProdject\Application\Application;

class User {

    private ?int $user_id;
    private ?string $userName;
    private ?string $userLastname;
    private ?string $userBirthday;

    public function __construct(int|null $user_id = null, string|null $name = null,
                            string|null $lastname = null, string|null $birthday = null) {
        $this->user_id = $user_id; 
        $this->userName = $name;
        $this->userLastname = $lastname;
        $this->userBirthday = $birthday;
    }

    public function getUserId(): int|null {
        return $this->user_id;
    }
    public function getUserName(): string|null {
        return $this->userName;
    }

    public function getUserLastname(): string|null {
        return $this->userLastname;
    }

    public function getUserBirthdayToString(): string|null {
        return $this->userBirthday;
    }
    public function getUserBirthdayToTimestemp(): int|null {
        return ($this->userBirthday != null) ? strtotime($this->userBirthday): null;
    }

    public function setUserId(int $user_id) : void {
        $this->user_id = $user_id;
    }

    public function setUserName(string $userName) : void {
        $this->userName = $userName;
    }

    public function setUserLastname(string $userLastname) : void {
        $this->userLastname = $userLastname;
    }

    public function setUserBirthday(string $userBirthday) : void {
        $this->userBirthday = $userBirthday;
    }

    public function setBirthdayFromString(string $birthdayString) : void {
        $this->userBirthday = strtotime($birthdayString);
    }
}
