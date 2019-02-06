<?php
/**
 * Created by PhpStorm.
 * User: kshahriyari
 * Date: 04.02.19
 * Time: 16:13
 */

namespace App\Influencer\Login\Logger;

use Monolog\Handler\HandlerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class LoginLogger extends Logger
{

    public function __construct()
    {
        parent::__construct('login_logger', [], []);
    }

    public function pushHandler(HandlerInterface $handler)
    {
        return parent::pushHandler(new StreamHandler('../var/log/login.log', Logger::DEBUG));
    }

}