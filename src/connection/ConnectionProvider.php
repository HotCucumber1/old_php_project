<?php
namespace App\connection;

use App\exception\DataBaseException;


class ConnectionProvider {
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
        try {

            return new \PDO($params['dsn'], $params['username'], $params['password']);
        }
        catch (\Exception $exception) {
            throw new DataBaseException("{$exception}");
        }
    }
}