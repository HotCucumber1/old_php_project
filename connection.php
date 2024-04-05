<?php

/**
 * Читает файл конфигурации и возвращает ассоциативный массив
 * с параметрами подключения
 * @return array{dsn:string,username:string,password:string}
 */
function getConnectionParams(): array
{
    require_once './config/config.php';
    return [
        'dsn' => DSN,
        'username' => USERNAME,
        'password' => PASSWORD
    ];
}


/**
 *Создаёт объект PDO, представляющий подключение к MySQL.
 * @return PDO
 */
function connectDatabase(array $params): PDO
{
    try {
        return new PDO($params['dsn'], $params['username'], $params['password']);
    }
    catch (Exception $exception) {
        throw new DataBaseException("{$exception}");
    }
}

