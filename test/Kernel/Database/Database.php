<?php

namespace App\Kernel\Database;

class Database
{
    private \PDO $pdo;
    public function __construct(){
        $this->connect();
    }

    public function first(string $table, array $conditions = []): ?array {
        $where = '';

        if (count($conditions) > 0) {
            $where = 'WHERE ' . implode(' AND ', array_map(fn ($field) => "$field = :$field", array_keys($conditions)));
        }
        $sql = "SELECT * FROM $table $where LIMIT 1";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($conditions); // Связываем параметры с реальными значениями

            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            return $result ?: null;
        } catch (\PDOException $e) {
            // Обработка ошибки запроса
            echo "Ошибка запроса: " . $e->getMessage();
            return null;
        }

    }
    public function insert(string $table, array $data): int|string {
        $fields = array_keys($data);

        $columns = implode(', ', $fields);
        $binds = implode(', ', array_map(fn ($field) =>":$field", $fields));

        $sql = "INSERT INTO $table ($columns) VALUES ($binds)";
        $stmt = $this->pdo->prepare($sql);

        try {
            $stmt->execute($data);
        } catch (\PDOException $exception) {
            exit($exception->getMessage());
        }
        return (int) $this->pdo->lastInsertId();
    }

    private function connect() {
        $params = require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';
        $dsn = 'mysql:host=' . $params['host'] . ';dbname=' . $params['dbname'];
        $dsnUser = $params['username'];
        $dsnPasswd = $params['password'];

        try {
            $this->pdo = new \PDO($dsn, $dsnUser, $dsnPasswd);
        } catch (\PDOException $exception){
            exit($exception->getMessage());
        }


    }
    public function get(string $table, array $conditions = []): array{
        $where = '';

        if (count($conditions) > 0) {
            $where = 'WHERE ' . implode(' AND ', array_map(fn ($field) => "$field = :$field", array_keys($conditions)));
        }
        $sql = "SELECT * FROM $table $where";


        $stmt = $this->pdo->prepare($sql);
        try {
            $stmt->execute($conditions);
        } catch (\PDOException $exception){
            exit($exception->getMessage());
        }// Связываем параметры с реальными значениями

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function delete(string $table, array $conditions = []): void{
        $where = '';

        if (count($conditions) > 0) {
            $where = 'WHERE ' . implode(' AND ', array_map(fn ($field) => "$field = :$field", array_keys($conditions)));
        }
        $sql = "DELETE FROM $table $where";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($conditions); // Связываем параметры с реальными значениями


    }

    public function update(string $table, array $data, array $conditions = []): void{
        $fields = array_keys($data);
        $set = implode(', ', array_map(fn ($field) => "$field = :$field", $fields));
        $where = '';
        if (count($conditions) > 0) {
            $where = 'WHERE ' . implode(' AND ', array_map(fn ($field) => "$field = :$field", array_keys($conditions)));
        }
        $sql = "UPDATE $table SET $set $where";
        $stmt = $this->pdo->prepare($sql);
        try {
            $stmt->execute(array_merge($data, $conditions));
        } catch (\PDOException $exception){
            exit($exception->getMessage());
        }

    }
    public function getWithJoin($tableMain, $tableJoin, $fieldSelect, $fieldJoinMain, $fieldJoinSecondary) {
        $sql = "SELECT {$tableMain}.*, GROUP_CONCAT($fieldSelect) as role_ids
                FROM {$tableMain}
                LEFT JOIN {$tableJoin} 
                ON {$tableMain}.{$fieldJoinMain} = {$tableJoin}.{$fieldJoinSecondary}
                GROUP BY {$tableMain}.{$fieldJoinMain}";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}