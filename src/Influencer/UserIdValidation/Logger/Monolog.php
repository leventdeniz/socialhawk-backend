<?php
/**
 * Created by PhpStorm.
 * User: levent
 * Date: 05.02.19
 * Time: 12:03
 */

namespace App\Influencer\UserIdValidation\Logger;

use Monolog\Handler\HandlerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Monolog extends Logger
{

    public function __construct()
    {
        parent::__construct('uid_validation_logger', [], []);
    }

    public function pushHandler(HandlerInterface $handler)
    {
        return parent::pushHandler(new StreamHandler('../var/log/uid_validation.log', Logger::DEBUG));
    }

}