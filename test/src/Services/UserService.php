<?php

namespace App\Services;
use App\Kernel\Database\Database;
use App\Models\Role;
use App\Models\User;

class UserService
{

    public function __construct(
        private Database $db,
    )
    {
    }

    public function all() {

        //$users = $this->db->get('users');
        $usersWithRoles = $this->db->getWithJoin(
            "users",
            "user_roles",
            "user_roles.role_id",
            "id",
            "user_id"
        );

        $users = array_map(function ($user) {
            $roles = $this->db->get('user_roles', [
                'user_id' => $user['id']
            ]);
            $roleIds = array_map(function($role) {
                return $role['role_id'];
            }, $roles);
            $user['role_ids'] = implode(',', $roleIds);
            return new User(
                id: $user['id'],
                name: $user['name'],
                email: $user['email'],
                password: $user['password'],
                avatar: $user['avatar'],
                roleId: $user['role_ids']
            );
        }, $usersWithRoles);
        return $users;
    }

    public function find(int $id): User|null{
        $user = $this->db->first('users', [
            'id' => $id
        ]);
        $roles = $this->db->get('user_roles', ['user_id' => $id]);
        $role_ids = [];

        foreach ($roles as $role) {
            $role_ids[] = $role['role_id'];
        }

        //$role_id = $role ? $role['role_id'] : null;

        if (!$user) {
            return null;
        } else {
            return new User(
                id: $user['id'],name: $user['name'],email: $user['email'],password: $user['password'],avatar: $user['avatar'],roleId: $role_ids
            );
        }
    }
    public function update(int $id, string $name, string $email, string $password, $avatar) {
        $this->db->update('users', [
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'avatar' => $avatar
        ], [
            'id' => $id
        ]);
    }

    public function getCurrentRoles($user) {
        $rolesService = new RoleService($this->db);

        // Предполагаем, что $user->roleIds() возвращает строку с идентификаторами ролей, разделенными запятыми
        $roleIds = explode(',', $user->roleId());

        $roleNames = array_map(function ($roleId) use ($rolesService) {
            $role = $rolesService->find($roleId);
            return $role ? $role->title() : 'Нет роли';
        }, $roleIds);

        // Возвращаем строку с названиями всех ролей пользователя
        return implode(', ', $roleNames);
    }
}