<?php

namespace App\Kernel;

use App\Kernel\Container\Container;
use App\Kernel\Http\Request;
use App\Kernel\Router\Router;

//Данный класс запускает приложение
class App
{
    private Container $container;

    public function __construct() {
        $this->container = new Container();
    }
    public function run(){

        $this->container->router->handleRequest(
            $this->container->request->uri(),
            $this->container->request->method()
        );
    }
}