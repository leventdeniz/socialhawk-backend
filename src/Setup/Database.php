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
        'password' => 'password',
        'database' => 'socialstars'
    ];

    public function connectToDatabase(){

        $conn = new mysqli(
            self::DATABASE_INFO['server'],
            self::DATABASE_INFO['username'],
            self::DATABASE_INFO['password'],
            self::DATABASE_INFO['database']
        );

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }

}