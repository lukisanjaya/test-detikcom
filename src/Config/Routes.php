<?php

namespace Detikcom\Config;

use Detikcom\Controllers\TicketController;
use Detikcom\Helper\APIResponse;
use Detikcom\Middleware\AuthBasicMiddleware;

class Routes
{
    public static function init()
    {
        $pathSegments = [];
        if ($_SERVER['REQUEST_URI'] != "/") {
            $pathSegments = explode('/', $_SERVER['REQUEST_URI']);

            foreach ($pathSegments as $q => $val) {
                if (empty($val)) {
                    unset($pathSegments[$q]);
                    $pathSegments = array_values($pathSegments);
                }
            }
        }

        if (count($pathSegments) > 1) {
            APIResponse::pageNotFound();
        }
        $segmentOne = !empty($pathSegments) ? parse_url($pathSegments[0])['path'] : "";

        switch ($segmentOne) {
            case 'check-ticket':
                AuthBasicMiddleware::init();
                $ticketController = new TicketController();
                $ticketController->checkTicket();
                break;

            case 'update-ticket':
                AuthBasicMiddleware::init();
                $ticketController = new TicketController();
                $ticketController->updateStatus();
                break;

            case 'doc':
                ob_start();
                include_once __DIR__ . '/../../doc/index.php';
                $var = ob_get_contents();
                ob_end_clean();
                echo $var;
                break;

            case 'openapi.json':
                $pathFile = __DIR__ . "/../../public/openapi.json";
                $fp = fopen($pathFile, 'rb');
                header('Content-Type: application/json');
                header('Content-length: ' . filesize($pathFile));
                fpassthru($fp);
                break;

            default:
                APIResponse::pageNotFound();
                break;
        }
    }
}
