<?php

namespace Detikcom\Models;

use Detikcom\Config\DB;
use Detikcom\Helper\Logger;

date_default_timezone_set('Asia/Jakarta');

class Model extends DB
{
    protected static function getById(string $tableName, int $id)
    {
        $stmt = self::getInstance()->prepare("SELECT * FROM $tableName WHERE id = :id");
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()) {
            return $stmt->fetchObject();
        } else {
            Logger::save($stmt->errorInfo());
        }
    }
}
