<?php

namespace App\Kernel\Container;

use App\Kernel\Auth\Auth;
use App\Kernel\Database\Database;
use App\Kernel\Http\Redirect;
use App\Kernel\Http\Request;
use App\Kernel\Router\Router;
use App\Kernel\Session\Session;
use App\Kernel\Storage\Storage;
use App\Kernel\Validator\Validator;
use App\Kernel\View\View;

class Container
{
    public readonly Request $request;

    public readonly Router $router;

    public readonly View $view;

    public readonly Validator $validator;

    public readonly Redirect $redirect;

    public readonly Session $session;

    public readonly Database $database;

    public readonly Auth $auth;

    public readonly Storage $storage;

    public function __construct() {
        $this->registerServices();
    }

    public function registerServices() {
        $this->request = Request::createFromGlobals();


        $this->validator = new Validator();
        $this->request->setValidator($this->validator);
        $this->redirect = new  Redirect();
        $this->session = new Session();
        $this->database = new Database();
        $this->auth = new Auth($this->database, $this->session);
        $this->view = new View($this->session, $this->auth);
        $this->storage = new Storage();
        $this->router = new Router($this->view, $this->request, $this->redirect, $this->session, $this->database, $this->auth, $this->storage);


    }

}