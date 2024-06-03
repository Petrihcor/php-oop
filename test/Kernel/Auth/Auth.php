<?php

namespace App\Kernel\Auth;

use App\Kernel\Database\Database;
use App\Kernel\Session\Session;

class Auth
{
    public function __construct(
        private Database $db,
        private Session $session
    )
    {
    }

    public function getUserOptions(){

        $options = require $_SERVER['DOCUMENT_ROOT'] . "/config/auth.php";

        return $options;

    }

    public function attempt(string $username, string $password): bool{

        $user = $this->db->first($this->getUserOptions()['table'], [
            $this->getUserOptions()['username'] => $username
        ]);

        if(!$user) {
            return false;
        }
        if(!password_verify($password, $user[$this->getUserOptions()['password']])) {
            return false;
        }

        $this->session->set($this->getUserOptions()['session_field'], $user['id']);

        $roles = $this->db->query("SELECT r.is_Admin FROM roles r
                                INNER JOIN user_roles ur ON r.id = ur.role_id
                                WHERE ur.user_id = ?", [$user['id']])->fetchAll(\PDO::FETCH_COLUMN);
        if (in_array(true, $roles)) {
            $this->session->set('is_admin', true);
        }
        // Сохраняем значения is_Admin в сессию

        return true;
    }

    public function logout(): void{
        $this->session->remove($this->getUserOptions()['session_field']);
    }
    public function check(): bool{
        return $this->session->has($this->getUserOptions()['session_field']);
    }
    public function isAdmin(): bool
    {
        return $this->session->has('is_admin') && $this->session->get('is_admin') === true;
    }
    public function user(): ?User{

        if (!$this->check()) {
            return null;
        }

        $user = $this->db->first($this->getUserOptions()['table'], [
            'id' => $this->session->get($this->getUserOptions()['session_field'])
        ]);
        if ($user) {
            return new User($user['id'],$user[$this->getUserOptions()['username']],$user[$this->getUserOptions()['password']],$user[$this->getUserOptions()['name']]);
        } else {
            return null;
        }
    }
}