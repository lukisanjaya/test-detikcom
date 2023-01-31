<?php

use Detikcom\Helper\TicketCLI;
use Detikcom\Models\Events;
use Detikcom\Models\Tickets;

require_once __DIR__ . '/vendor/autoload.php';

$ticketCLI = new TicketCLI($argc, $argv);
if (!$argc || $argc <= 2) {
    $ticketCLI->getHelp();
}

$param1 = $ticketCLI->getArgument(1);
$param2 = $ticketCLI->getArgument(2);

if ($param1 == '-h') {
    $ticketCLI->getHelp();
}

$eventID =  $param1;
$totalTicket =  $param2;

if (ctype_alpha($eventID)) {
    echo "Please, input valid value 'EventID'";
    echo PHP_EOL;
    die;
}

$events = Events::findById($eventID);
if (!$events) {
    echo "EventID not Found";
    echo PHP_EOL;
    die;
}

if (ctype_alpha($totalTicket)) {
    echo "Please, input valid value 'TotalTicket'";
    echo PHP_EOL;
    die;
}

echo "Running... Process Generate {$totalTicket} ticket from EventID : {$eventID}";
echo PHP_EOL;
echo PHP_EOL;

$ticket = new Tickets();
for ($i = 1; $i <= $totalTicket; $i++) {

    $loop = true;
    while ($loop) {
        $ticketCode = "DTK" . $ticketCLI::getUniqueID();
        $checkTicket = $ticket::checkTicket($eventID, $ticketCode);
        if (!$checkTicket) {
            $loop = false;
        }
    }

    $data = [
        'event_id'    => $eventID,
        'ticket_code' => $ticketCode,
    ];

    $lastInsertId = $ticket::insert($data);
    if ($lastInsertId) {
        echo "Successfully, Generate Ticket - {$i} : ";
        echo $ticketCode;
        echo PHP_EOL;
    }
}
