<?php
namespace App\model;
use PDO;
use App\exception\DataBaseException;

//require_once '../../config/config.php';

class ConnectionProvider
{
    public static function connectDatabase(): \PDO
    {
        try {
            return new PDO(DSN, USERNAME, PASSWORD);
        }
        catch (\Exception $exception) {
            throw new DataBaseException("{$exception}");
        }
    }
}