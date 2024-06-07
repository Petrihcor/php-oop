<?php

namespace App\controllers;


use App\Kernel\Controller\Controller;
use App\Kernel\View\View;
use App\Services\RoleService;
use App\Services\UserService;

class MainController extends Controller
{


    private UserService $userService;
    private function userService() {
        if (!isset($this->userService)) {
            $this->userService = new  UserService($this->db());
        }
        return $this->userService;
    }
    public function getAllUsers() {

        $usersService = new UserService($this->db());

        $usersData = $usersService->all();
        $usersWithRoles = array_map(function ($user) use ($usersService) {

           // Получаем названия ролей пользователя с помощью нового метода
            $user->roleName = $usersService->getCurrentRoles($user);

            return $user;
        }, $usersData);

        $this->view('index.tpl', [
            'users' => $usersWithRoles,
        ]);
    }
    public function getAllRoles() {
        $roles = new RoleService($this->db());

        $this->view('roles.tpl', [
            'roles' => $roles->all()
        ]);
    }
    public function showUser() {
        $rolesService = new RoleService($this->db());
        $user = $this->userService()->find($this->request()->input('id'));

        foreach ($user->roleId() as $rolesId) {
            $roles[] = $rolesService->find($rolesId);
        }

        $this->view('user.tpl',[
            'user' => $user,
            'roles' => $roles
        ]);
    }

}