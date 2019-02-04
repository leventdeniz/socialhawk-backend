<?php
/**
 * Created by PhpStorm.
 * User: kian
 * Date: 30.01.19
 * Time: 21:33
 */

namespace App\Setup;

use mysqli;
use App\Logger;

class Database
{
    const DATABASE_INFO = [
        'server' => 'localhost',
        'username' => 'root',
        'password' => 'password99#',
        'database' => 'influencer'
    ];

    protected $_monolog;

    public function __construct()
    {
        $this->_monolog = new Logger\Monolog();
    }

    public function connectToDatabase(){

        try {
            $conn = new mysqli(
                self::DATABASE_INFO['server'],
                self::DATABASE_INFO['username'],
                self::DATABASE_INFO['password'],
                self::DATABASE_INFO['database']
            );

        }catch (\Exception $e){

            $this->_monolog->critical('Not database connection possible!', ['exception' => $e]);
            return false;

        }

        return $conn;
    }

}