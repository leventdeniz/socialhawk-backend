<?php
/**
 * Created by PhpStorm.
 * User: kian
 * Date: 30.01.19
 * Time: 21:25
 */

namespace App\Influencer\Setup\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InstallInfluencerDatabase extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'era:influencer:create-database';

    /**
     * @var \App\Influencer\Setup\Model\CreateDatabase
     */
    protected $_createDatabaseModel;

    /**
     * InstallInfluencerDatabase constructor.
     * @param string|null $name
     * @param \App\Influencer\Setup\Model\CreateDatabase $createDatabase
     */
    public function __construct(
        string $name = null,
        \App\Influencer\Setup\Model\CreateDatabase $createDatabase)
    {
        parent::__construct($name);
        $this->_createDatabaseModel = $createDatabase;
    }

    protected function configure()
    {
        $this
            ->setDescription('Create influencer database.')
            ->setHelp('Create the database structure for the influencer user');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        echo "Installing Influencer database structure";
        $this->_createDatabaseModel->installSchema();
    }

}