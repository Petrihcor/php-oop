<?php

namespace App\Kernel\Controller;

use App\Kernel\Auth\Auth;
use App\Kernel\Database\Database;
use App\Kernel\Http\Redirect;
use App\Kernel\Http\Request;
use App\Kernel\Session\Session;
use App\Kernel\Storage\Storage;
use App\Kernel\View\View;

abstract class Controller
{
    private View $view;
    private Request $request;

    private Redirect $redirect;

    private Session $session;

    private Database $database;

    private Auth $auth;

    private Storage $storage;


    public function storage(): Storage
    {
        return $this->storage;
    }


    public function setStorage(Storage $storage): void
    {
        $this->storage = $storage;
    }


    public function auth(): Auth
    {
        return $this->auth;
    }


    public function setAuth(Auth $auth): void
    {
        $this->auth = $auth;
    }
    public function db(): Database
    {
        return $this->database;
    }


    public function setDatabase(Database $database): void
    {
        $this->database = $database;
    }


    public function session(): Session
    {
        return $this->session;
    }


    public function setSession(Session $session): void
    {
        $this->session = $session;
    }

    public function request(): Request
    {
        return $this->request;
    }

    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    public function view(string $name, array $data = []): void {
        $this->view->page($name, $data);
    }


    public function setView(View $view): void
    {
        $this->view = $view;
    }


    public function setRedirect(Redirect $redirect): void
    {
        $this->redirect = $redirect;
    }

    public function redirect(string $url): Redirect{
        $this->redirect->to($url);
    }


}