<?php

namespace App\Logger;

use Monolog\Handler\HandlerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;


class Monolog extends Logger
{
    public function __construct()
    {
        parent::__construct('database_logger', [], []);
    }

    public function pushHandler(HandlerInterface $handler)
    {
        return parent::pushHandler(new StreamHandler('../var/log/database.log', Logger::DEBUG));
    }

}