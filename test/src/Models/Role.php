<?php

namespace App\Models;

class Role
{

    public function __construct(
        private int $id,
        private string $title,
        private string $description,
        private bool $isAdmin
    )
    {
    }


    public function id(): int
    {
        return $this->id;
    }


    public function title(): string
    {
        return $this->title;
    }


    public function description(): string
    {
        return $this->description;
    }


    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }


}