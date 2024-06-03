<?php

namespace App\Models;

class User
{
    public $roleName;
    public function __construct(
        private int $id,
        private string $name,
        private string $email,
        private string $password,
        private $avatar,
        private $roleId,
    )
    {
    }


    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }


    public function email(): string
    {
        return $this->email;
    }


    public function password(): string
    {
        return $this->password;
    }

    public function avatar(): string|null
    {
        return $this->avatar;
    }


    public function roleId()
    {
        return $this->roleId;
    }




}