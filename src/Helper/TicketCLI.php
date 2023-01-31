<?php

namespace Detikcom\Helper;

class TicketCLI
{
    public static int $argc;
    public static array $argv;

    public function __construct($argc, $argv)
    {
        self::$argc = $argc;
        self::$argv = $argv;
    }

    public static function getHelp(): void
    {
        echo "Usage php ticket.php :";
        echo PHP_EOL;
        echo PHP_EOL;
        echo "php ticket.php eventID TotalTicket";
        echo PHP_EOL;
        echo PHP_EOL;
        echo "example :";
        echo PHP_EOL;
        echo "php ticket.php 1 100";
        echo PHP_EOL;
        die;
    }

    public static function getArgument(int $val, $totalArgs = 2): string
    {
        $args = array_fill(0, $totalArgs, null);
        if ($val < 1 || $val > $totalArgs) {
            echo "Invalid Value";
            die;
        }

        for ($i = 1; $i < self::$argc; $i++) {
            $args[$i - 1] = self::$argv[$i];
        }

        return $args[$val - 1];
    }

    public static function getUniqueID(int $totalString = 10): string
    {
        $permittedChars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($permittedChars), 0, $totalString);
    }
}
