<?php

namespace App\controllers;
class RegisterController extends \App\Kernel\Controller\Controller
{
    public function index(){
        $this->view('register.tpl');
    }
    public function registration(){

        $file = $this->request()->file('image');
        //id пользователя в названии это временное решение, чтобы не случилось загрузки файлов с одинаковыми названиями двумя разными пользователями
        $filepath = $file->move('images/avatars', "{$this->request()->input('id')}{$this->request()->file('image')->name}");
        $validation = $this->request()->validate([
            'name' => ['required', 'min:3', 'max:255'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'min:8']
        ]);
        if (! $validation) {
            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }
            $this->redirect('/register');

        } else {
            $user_id = $this->db()->insert('users', [
                'name' => $this->request()->input('name'),
                'email' => $this->request()->input('email'),
                'password' => password_hash($this->request()->input('password'), PASSWORD_DEFAULT),
                'avatar' => $this->request()->file('image')->name
            ]);
            $this->db()->insert('user_roles', [
                'role_id' => 29,
                'user_id' => $user_id,

            ]);

            $this->redirect('/');

        }
    }

}