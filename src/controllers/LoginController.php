<?php

namespace App\controllers;
class LoginController extends \App\Kernel\Controller\Controller
{
    public function index(): void{
        $this->view('login.tpl');
    }
    public function  login() {
        $email = $this->request()->input('email');

        $password = $this->request()->input('password');
        if ($this->auth()->attempt($email, $password)) {
            $this->redirect('/');
        } else {
            $this->session()->set('error', 'Неверный логин или пароль');
            $this->redirect('/login');
        }
    }
    public function logout(){
        session_destroy();
        return $this->redirect('/login');
    }
}