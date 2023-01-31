<?php

namespace Detikcom\Helper;

class Logger
{
    public static function save($error): void
    {
        $datetime = new \DateTime();
        $datetime->setTimezone(new \DateTimeZone('Asia/Jakarta'));
        $logMessage = $datetime->format('Y/m/d H:i:s') . ' ' . json_encode($error). "\n";

        $fileNameLog = __DIR__ . "/../../logs/log-" . date('Y-m-d') . ".txt";
        error_log($logMessage, 3, $fileNameLog);
    }
}
