<?php
/**
 * Created by PhpStorm.
 * User: kshahriyari
 * Date: 06.02.19
 * Time: 16:58
 */

namespace App\Influencer\MailerService\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RegisterVerificationCommand extends Command
{
    protected static $defaultName = 'influencer:mail:verification';

    protected function configure()
    {
        $this
            ->setDescription('Send register verification mail to unverified users')
            ->setHelp('Routine will check the users table and see for users with not verification. After that it will send them an verification email')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $mailer = new \App\Influencer\MailerService\Model\Mailer();
        $mailer->sendMailToAllUnverified();
    }

}