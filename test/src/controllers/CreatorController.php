<?php

namespace App\controllers;

use App\Kernel\Controller\Controller;
use App\Kernel\Http\Redirect;
use App\Kernel\Validator\Validator;
use App\Kernel\View\View;
use App\Services\RoleService;
use App\Services\UserService;

class CreatorController extends Controller
{
    private RoleService $roleService;
    private UserService $userService;
    private function roleService() {
        if (!isset($this->roleService)) {
            $this->roleService = new  RoleService($this->db());
        }
        return $this->roleService;
    }
    private function userService() {
        if (!isset($this->userService)) {
            $this->userService = new  UserService($this->db());
        }
        return $this->userService;
    }
    public function addRole() {
        $this->view('admin/role-create.tpl');
    }
    public function editRole() {

        $role = $this->roleService()->find($this->request()->input('id'));
        $this->view('admin/role-update.tpl',[
            'role' => $role
        ]);
    }
    public function updateRole(){

        $validation = $this->request()->validate([
            'title' => ['required', 'min:3', 'max:50'],
        ]);
        if (! $validation) {
            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }
            $this->redirect('/role/create');

        }
        $this->roleService()->update(
            $this->request()->input('id'),
            $this->request()->input('title'),
            $this->request()->input('is_Admin'),
            $this->request()->input('description')
        );

        return $this->redirect("/role/edit?id={$this->request()->input('id')}");
    }


    public function saveRole() {


        $validation = $this->request()->validate([
            'title' => ['required', 'min:3', 'max:50'],
        ]);
        if (! $validation) {
            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }
            $this->redirect('/role/create');

        } else {
            $id = $this->db()->insert('roles', [
                'title' => $this->request()->input('title'),
                'description' => $this->request()->input('description'),
                'is_admin' => $this->request()->input('is_Admin')
            ]);

            return $this->redirect("/roles");
        }
    }

    public function deleteRole() {

        $roleId = $this->request()->input('id');

        //временное решение
        if ($roleId == 28 || 29) {
            return $this->redirect("/roles");
        }
        $this->db()->delete('user_roles', [
            'role_id' => $roleId
        ]);
        $this->db()->delete('roles', [
            'id' => $roleId
        ]);

        return $this->redirect("/roles");
    }

    public function addUser() {

        $this->view('admin/user-create.tpl');
    }
    public function editUser() {
        $user = $this->userService()->find($this->request()->input('id'));

        $roles = new RoleService($this->db());

        $this->view('admin/user-update.tpl', [
            'user' => $user,
            'roles' => $roles->all()
        ]);
    }
    public function updateUser(){

        $file = $this->request()->file('image');
        if ($file->tmp_name) {
            $filepath = $file->move('images/avatars', "{$this->request()->input('id')}{$this->request()->file('image')->name}");
        }
        //id пользователя в названии это временное решение, чтобы не случилось загрузки файлов с одинаковыми названиями двумя разными пользователями
        
        $validation = $this->request()->validate([
            'name' => ['required', 'min:3', 'max:255'],
            'email' => ['required', 'email'],
            'role_id' => ['required']
        ]);
        if (! $validation) {
            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }
            $this->redirect("/user/edit?id={$this->request()->input('id')}");

        }

        $this->userService()->update(
            $this->request()->input('id'),
            $this->request()->input('name'),
            $this->request()->input('email'),
            $this->request()->input('password'),
            $this->request()->file('image')->name,
        );

        $this->db()->delete('user_roles', ['user_id' => $this->request()->input('id')]);
        foreach ($this->request()->input('role_id') as $role) {
            $this->db()->insert('user_roles', [
                'role_id' => $role,
                'user_id' => $this->request()->input('id'),
            ]);
        }

        return $this->redirect("/user?id={$this->request()->input('id')}");
    }

    public function saveUser() {

        $file = $this->request()->file('image');

        $filepath = $file->move('images/avatars');

        $validation = $this->request()->validate([
            'name' => ['required', 'min:3', 'max:255'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'min:8'],
            'role_id' => ['required']
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
                'avatar' => $this->request()->input('image'),
            ]);
            $this->db()->insert('user_roles', [
                'role_id' => 29,
                'user_id' => $user_id,

            ]);

            $this->redirect('/');

        }
    }

    public function deleteUser() {
        $userId = $this->request()->input('id');
        //временное решение
        if ($userId == 5) {
            return $this->redirect("/");
        }
        $this->db()->delete('user_roles', [
            'user_id' => $userId
        ]);

        $this->db()->delete('users', [
            'id' => $userId
        ]);

        return $this->redirect("/");
    }
}