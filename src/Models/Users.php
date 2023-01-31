<?php

namespace Detikcom\Models;

use Detikcom\Helper\Logger;
use Exception;

class Users extends Model
{
    public static function insert(string $username, string $password)
    {
        $insertDefaultUsers = "INSERT INTO users (username, password) VALUES (:username, :password);";
        try {
            $stmt = self::getInstance()->prepare($insertDefaultUsers);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":password", $password);
            $stmt->execute();
            return self::getInstance()->lastInsertId();
        } catch (\PDOException $e) {
            Logger::save($e);
        }
    }

    public static function getByUsername(string $username)
    {
        try {
            $stmt = self::getInstance()->prepare("SELECT username, password FROM users WHERE username=:username");
            $stmt->bindParam(":username", $username);
            if ($stmt->execute()) {
                return $stmt->fetchObject();
            } else {
                Logger::save($stmt->errorInfo());
            }
        } catch (Exception $e) {
            Logger::save($stmt);
        }
    }
}
