<?php
/**
 * Created by PhpStorm.
 * User: kian
 * Date: 30.01.19
 * Time: 21:33
 */

namespace App\Setup;

use mysqli;

class Database
{
    const DATABASE_INFO = [
        'server' => 'localhost',
        'username' => 'root',
        'password' => 'password99#',
        'database' => 'influencer'
    ];

    public function connectToDatabase(){

        $conn = new mysqli(
            self::DATABASE_INFO['server'],
            self::DATABASE_INFO['username'],
            self::DATABASE_INFO['password'],
            self::DATABASE_INFO['database']
        );

        if ($conn->connect_error) {
            return false;
        }

        return $conn;
    }

}