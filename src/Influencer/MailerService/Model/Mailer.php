<?php
/**
 * Created by PhpStorm.
 * User: kshahriyari
 * Date: 06.02.19
 * Time: 17:03
 */

namespace App\Influencer\MailerService\Model;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    protected $_mailer;

    public function __construct()
    {
        $this->_mailer = new PHPMailer(true);
    }

    /**
     * Send verification email to every unverified user
     */
    public function sendMailToAllUnverified()
    {
        try {

            $this->_mailer->setFrom('kshahriyari@protonmail.com', 'Kian');
            $this->_mailer->addAddress('kshahriyari@protonmail.com');

            $this->_mailer->isHTML(true);
            $this->_mailer->Subject = 'A very simple test';
            $this->_mailer->Body = "Hello world";

            $this->_mailer->send();

            echo "email has been sent";

        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }

    }

}