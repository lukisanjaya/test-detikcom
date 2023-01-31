<?php

namespace Detikcom\Models;

use Detikcom\Helper\Logger;

class Events extends Model
{
    private static $tableName = "events";

    public static function insertMultiple(array $data)
    {
        $insertDummyEvents = <<<END
            INSERT INTO events (
                title,
                description,
                location,
                start_date,
                end_date,
                created_at,
                updated_at
            )
            VALUES(
                :title,
                :description,
                :location,
                :start_date,
                :end_date,
                :created_at,
                :updated_at
            );
        END;

        try {
            $stmt = self::getInstance()->prepare($insertDummyEvents);

            foreach ($data as $row) {
                $stmt->execute($row);
            }
        } catch (\PDOException $e) {
            Logger::save($e);
        }
    }

    public static function findById($id)
    {
        return self::getById(self::$tableName, $id);
    }
}
