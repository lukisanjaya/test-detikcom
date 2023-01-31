<?php

namespace Detikcom\Middleware;

use Detikcom\Helper\APIResponse;
use Detikcom\Helper\Logger;
use Detikcom\Models\Users;
use Exception;

class AuthBasicMiddleware
{
    public static function init()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            APIResponse::unauthorized();
        }

        $username = $_SERVER['PHP_AUTH_USER'];

        try {
            $user = Users::getByUsername($username);
        } catch (Exception $e) {
            Logger::save($e);
        }
        if (empty($user)) {
            APIResponse::unauthorized();
        }

        $password = $_SERVER['PHP_AUTH_PW'];

        if (!password_verify($password, $user->password)) {
            APIResponse::unauthorized();
        }
    }
}
