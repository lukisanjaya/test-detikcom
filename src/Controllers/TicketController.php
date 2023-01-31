<?php

namespace Detikcom\Controllers;

use Detikcom\Helper\APIResponse;
use Detikcom\Models\Tickets;
use Exception;

class TicketController
{
    public function checkTicket()
    {
        if ($_SERVER['REQUEST_METHOD'] != "GET") {
            APIResponse::pageNotFound();
        }

        $errors = [];
        if (!isset($_GET['event_id']) || empty($_GET['event_id'])) {
            $errors['event_id'] = 'event_id is required';
        }

        if (!isset($_GET['ticket_code']) || empty($_GET['ticket_code'])) {
            $errors['ticket_code'] = 'ticket_code is required';
        }

        if (!empty($errors)) {
            APIResponse::badRequest($errors);
        }

        $eventID    = (int) $_GET['event_id'];
        $ticketCode = (string) $_GET['ticket_code'];
        $ticket     = Tickets::checkTicket($eventID, $ticketCode);
        $response = [
            'ticket_code' => $ticket->ticket_code,
            'status'      => $ticket->status,
        ];

        if ($ticket) {
            APIResponse::success($response);
        } else {
            APIResponse::notFound();
        }
    }

    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] != "POST") {
            APIResponse::pageNotFound();
        }

        $errors = [];
        if (!isset($_POST['event_id']) || empty($_POST['event_id'])) {
            $errors['event_id'] = 'event_id is required';
        }

        if (!isset($_POST['ticket_code']) || empty($_POST['ticket_code'])) {
            $errors['ticket_code'] = 'ticket_code is required';
        }

        if (!isset($_POST['status']) || empty($_POST['status'])) {
            $errors['status'] = 'status is required';
        }

        if (!empty($errors)) {
            APIResponse::badRequest($errors);
        }

        $eventID    = $_POST['event_id'];
        $ticketCode = $_POST['ticket_code'];
        $status     = $_POST['status'];

        $ticket = new Tickets();
        try {
            $checkTicket = $ticket::checkTicket($eventID, $ticketCode);
            if (!$checkTicket) {
                throw new Exception("data not found");
            }
        } catch (Exception $e) {
            APIResponse::notFound();
        }

        try {
            $ticket::updateStatusTicket($eventID, $ticketCode, $status);
        } catch (Exception $e) {
            APIResponse::badRequest();
        }

        $getTicket = $ticket::checkTicket($eventID, $ticketCode);

        $response = [
            'ticket_code' => $getTicket->ticket_code,
            'status'      => $getTicket->status,
            'updated_at'  => $getTicket->updated_at
        ];
        APIResponse::success($response);
    }
}
