<?php
namespace App\Connection;


class ConnectionProvider
{
    static public function getConnectionParams(): array
    {
        require_once './config/config.php';
        return [
            'dsn' => DSN,
            'username' => USERNAME,
            'password' => PASSWORD
        ];
    }

    static function connectDatabase(array $params): \PDO
    {
        return new \PDO($params['dsn'], $params['username'], $params['password']);
    }
}
