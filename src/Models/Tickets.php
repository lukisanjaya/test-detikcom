<?php

namespace Detikcom\Models;

use Detikcom\Models\Model;
use Detikcom\Helper\Logger;
use Exception;

class Tickets extends Model
{
    private static $tableName = "tickets";

    public static function insert(array $data)
    {
        $sql = <<<END
            INSERT INTO tickets (
                event_id,
                ticket_code,
                created_at,
                updated_at
            )
            VALUES(
                :event_id,
                :ticket_code,
                :created_at,
                :updated_at
            );
        END;

        $eventId    = $data['event_id'];
        $ticketCode = $data['ticket_code'];
        $dateNow    = date('Y-m-d H:i:s');

        try {
            $stmt = self::getInstance()->prepare($sql);
            $stmt->bindParam(":event_id", $eventId);
            $stmt->bindParam(":ticket_code", $ticketCode);
            $stmt->bindParam(":created_at", $dateNow);
            $stmt->bindParam(":updated_at", $dateNow);
            $stmt->execute();
            return self::getInstance()->lastInsertId();
        } catch (\PDOException $e) {
            Logger::save($e);
        }
    }

    public static function findById($id)
    {
        return self::getById(self::$tableName, $id);
    }

    public static function checkTicket(int $eventID, string $ticketCode)
    {
        $stmt = self::getInstance()->prepare("SELECT ticket_code, status, updated_at FROM tickets WHERE event_id=:event_id AND ticket_code=:ticket_code");
        $stmt->bindParam(":event_id", $eventID);
        $stmt->bindParam(":ticket_code", $ticketCode);
        if ($stmt->execute()) {
            return $stmt->fetchObject();
        } else {
            Logger::save($stmt->errorInfo());
        }
    }

    public static function claimTicket(string $ticketCode)
    {
        $sql = "UPDATE tickets SET status=:status, updated_at=:updated_at WHERE ticket_code=:ticket_code";

        $status  = "claimed";
        $dateNow = date('Y-m-d H:i:s');

        try {
            $stmt = self::getInstance()->prepare($sql);
            $stmt->bindParam(":ticket_code", $ticketCode);
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":updated_at", $dateNow);
            if (!$stmt->execute()) {
                throw new Exception("Failed, update Data");
            }
            return $stmt;
        } catch (\PDOException $e) {
            Logger::save($e);
        }
    }

    public static function updateStatusTicket(int $eventID, string $ticketCode, string $status)
    {
        $sql = "UPDATE tickets SET status=:status, updated_at=:updated_at WHERE ticket_code=:ticket_code AND event_id=:event_id";

        $dateNow = date('Y-m-d H:i:s');

        try {
            $stmt = self::getInstance()->prepare($sql);
            $stmt->bindParam(":event_id", $eventID);
            $stmt->bindParam(":ticket_code", $ticketCode);
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":updated_at", $dateNow);
            if (!$stmt->execute()) {
                throw new Exception("Failed, update Data");
            }
            return $dateNow;
        } catch (\PDOException $e) {
            Logger::save($e);
        }
    }
}
