<?php

use Detikcom\Helper\Logger;
use Detikcom\Models\Events;
use Detikcom\Models\Model;
use Detikcom\Models\Tickets;
use Detikcom\Models\Users;

require_once __DIR__ . '/vendor/autoload.php';

class Migration extends Model
{
    public static function createTableUsers(): void
    {
        $createTableUsers = <<<END
            CREATE TABLE users (
                id int NOT NULL AUTO_INCREMENT,
                username varchar(255) NOT NULL,
                password varchar(255) NOT NULL,
                PRIMARY KEY (id),
                UNIQUE (username)
            );
        END;

        try {
            self::getInstance()->prepare($createTableUsers)->execute();
            echo "successfully, create table users" . PHP_EOL;
        } catch (\PDOException $e) {
            Logger::save($e);
        }

        $username     = "admin";
        $hashPassword = password_hash('rahasia', PASSWORD_DEFAULT);

        $user = Users::insert($username, $hashPassword);
        if ($user) {
            echo "successfully, insert default users" . PHP_EOL;
        }
    }

    public static function createTableEvent(): void
    {
        $createTableEvent = <<<END
            CREATE TABLE events (
                id int NOT NULL AUTO_INCREMENT,
                title varchar(255) NOT NULL,
                description varchar(255),
                location varchar(255) NOT NULL,
                start_date datetime NOT NULL,
                end_date datetime NOT NULL,
                created_at timestamp,
                updated_at timestamp,
                PRIMARY KEY (id)
            );
        END;

        try {
            self::getInstance()->prepare($createTableEvent)->execute();
            echo "successfully, create table events" . PHP_EOL;
        } catch (\PDOException $e) {
            Logger::save($e);
        }

        $dateNow = date('Y-m-d H:i:s');

        $dataEvents = [
            [
                "title"       => "Coffee & Sneakers Lokal",
                "description" => "Acara keren kayak gini gak boleh di-skipppp!",
                "location"    => "Lippo Mall Puri",
                "start_date"  => "2023-02-03 08:00:00",
                "end_date"    => "2023-02-03 09:00:00",
                "created_at"  => $dateNow,
                "updated_at"  => $dateNow,
            ],
            [
                "title"       => "Indonesia International Furniture Expo (IFEX) 2023",
                "description" => "Indonesia International Furniture Expo (IFEX) offers the largest range of specialty furniture and craft products which discover the perfect blend of good design and fine craftsmanship edition inspired by the natural wealth of Indonesia.",
                "location"    => "JIExpo Kemayoran Jakarta",
                "start_date"  => "2023-02-05 08:00:00",
                "end_date"    => "2023-02-05 15:00:00",
                "created_at"  => $dateNow,
                "updated_at"  => $dateNow,
            ],
            [
                "title"       => "Pameran Muslim LifeFest 2023",
                "description" => "Muslim-mate, Muslim LifeFest merupakan puncak pameran dari beberapa rangkaian kegiatan pameran kami. “The Biggest & Most Comprehensive Islamic & Halal Lifestyle Exhibition in Indonesia”",
                "location"    => "ICE BSD City",
                "start_date"  => "2023-08-25 08:00:00",
                "end_date"    => "2023-08-27 15:00:00",
                "created_at"  => $dateNow,
                "updated_at"  => $dateNow,
            ]
        ];

        Events::insertMultiple($dataEvents);
        echo "successfully, insert dummy events" . PHP_EOL;
    }

    public static function createTableTicket(): void
    {
        $createTableTicket = <<<END
            CREATE TABLE tickets (
                id int NOT NULL AUTO_INCREMENT,
                event_id int,
                ticket_code varchar(255) NOT NULL,
                status ENUM('available', 'claimed') DEFAULT 'available',
                created_at timestamp,
                updated_at timestamp,
                PRIMARY KEY (id),
                FOREIGN KEY (event_id) REFERENCES events(id),
                UNIQUE (ticket_code)
            );
        END;

        try {
            self::getInstance()->prepare($createTableTicket)->execute();
            echo "successfully, create table tickets" . PHP_EOL;
        } catch (\PDOException $e) {
            Logger::save($e);
        }

        $dataDummy = [
            'ticket_code' => 'DTK9zKXCowpWx',
            'event_id' => 1
        ];

        if (Tickets::insert($dataDummy)) {
            echo "successfully, insert dummy tickets" . PHP_EOL;
        }
    }
}

$migration = new Migration();
$migration->createTableUsers();
$migration->createTableEvent();
$migration->createTableTicket();
