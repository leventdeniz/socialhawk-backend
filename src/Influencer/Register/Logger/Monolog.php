<?php
/**
 * Created by PhpStorm.
 * User: kshahriyari
 * Date: 04.02.19
 * Time: 17:13
 */

namespace App\Influencer\Register\Logger;

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
        return parent::pushHandler(new StreamHandler('../var/log/register.log', Logger::DEBUG));
    }

}