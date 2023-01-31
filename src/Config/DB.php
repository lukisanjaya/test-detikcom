<?php

namespace Detikcom\Config;

use Detikcom\Helper\APIResponse;
use Detikcom\Helper\Logger;

class DB
{
    private const DB_HOST = "localhost";
    private const DB_USER = "akun";
    private const DB_PASS = "akun";
    private const DB_NAME = "tiket_test";
    private static $db = null;

    public static function getInstance()
    {
        if (self::$db === null) {
            $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8', self::DB_HOST, self::DB_NAME);
            try {
                self::$db = new \PDO($dsn, self::DB_USER, self::DB_PASS, [
                    \PDO::ATTR_TIMEOUT => 5,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_SILENT
                ]);
            } catch (\PDOException $e) {
                Logger::save($e);
                APIResponse::serverError();
            }
        }
        return self::$db;
    }

    public function __destruct()
    {
        self::$db = null;
        // echo 'Successfully disconnected from the database!';
    }
}
