<?php
/**
 * Created by PhpStorm.
 * User: kian
 * Date: 30.01.19
 * Time: 21:29
 */

namespace App\Influencer\Setup\Model;

use mysqli;

class CreateDatabase
{

    /**
     * @var \App\Setup\Database
     */
    protected $_databaseInfo;

    /**
     * CreateDatabase constructor.
     * @param \App\Setup\Database $database
     */
    public function __construct(\App\Setup\Database $database) {
        $this->_databaseInfo = $database;
    }


    public function installSchema(){
        $connection = $this->_databaseInfo->connectToDatabase();

        $sql = '
            CREATE TABLE InfluencerUsers(
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255),
            password VARCHAR (512),
            regData TIMESTAMP
            )
        ';

        if($connection->query($sql)){
            echo "Table for Influencer successfully created";
        }
    }

}