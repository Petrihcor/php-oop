<?php

namespace App\Kernel\View;

use App\Kernel\Auth\Auth;
use App\Kernel\Exceptions\ViewNotFound;
use App\Kernel\Session\Session;

class View
{
    public function __construct(
        private Session $session,
        private Auth $auth
    )
    {
    }

    public function page(string $name, array $data = []): void {
        $viewPath = $_SERVER['DOCUMENT_ROOT'] . "/src/views/pages/{$name}.php";
        if (!file_exists($viewPath)){
            throw new ViewNotFound("View $name not found");
        }

        extract(array_merge($this->defaultData(), $data));
        require_once $viewPath;
    }
    public function incs(string $name): void {
        $incsPath = $_SERVER['DOCUMENT_ROOT'] . "/src/views/incs/{$name}.php";
        if (!file_exists($incsPath)){
            echo "Component $name not found";
            return;
        }
        extract($this->defaultData());
        require_once $_SERVER['DOCUMENT_ROOT'] . "/src/views/incs/{$name}.php";
    }
    private function defaultData(): array {
        return [
            'view' => $this,
            'session' => $this->session,
            'auth' => $this->auth
        ];
    }
}