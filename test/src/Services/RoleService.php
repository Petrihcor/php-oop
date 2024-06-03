<?php

namespace App\Services;
use App\Kernel\Database\Database;
use App\Models\Role;

class RoleService
{

    public function __construct(
        private Database $db,
    )
    {
    }

    public function all(): array {
        $roles = $this->db->get('roles');
        $roles = array_map(function ($role) {
            return new Role(
                id: $role['id'],
                title: $role['title'],
                description: $role['description'],
                isAdmin: $role['is_Admin']
            );
        }, $roles);
        return $roles;
    }

    public function find(int $id){
        $role = $this->db->first('roles', [
            'id' => $id
        ]);
        if (!$role) {
            return null;
        } else {
            return new Role(
                id: $role['id'],title: $role['title'],description: $role['description'],isAdmin: $role['is_Admin']
            );
        }
    }


    public function update(int $id, string $title, int $isAdmin, string $description) {
        $this->db->update('roles', [
            'title' => $title,
            'is_Admin' => $isAdmin,
            'description' => $description
        ], [
            'id' => $id
        ] );
    }
}