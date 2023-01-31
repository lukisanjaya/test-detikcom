<?php

use Detikcom\Config\Routes;
use Detikcom\Middleware\AuthBasicMiddleware;


require_once __DIR__ . '/../vendor/autoload.php';

define('IS_DIRECT', true);

Routes::init();
