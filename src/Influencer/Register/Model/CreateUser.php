<?php
/**
 * Created by PhpStorm.
 * User: kian
 * Date: 02.02.19
 * Time: 11:13
 */

namespace App\Influencer\Register\Model;


class CreateUser
{
    /**
     * @var \App\Setup\Database
     */
    protected $_databaseConnection;

    /**
     * @var \App\Influencer\Register\Logger\RegisterLogger
     */
    protected $_monolog;

    public function __construct()
    {
        $this->_databaseConnection = new \App\Setup\Database();
        $this->_monolog = new \App\Influencer\Register\Logger\RegisterLogger();
    }

    public function createNewInfluencerUser($email, $password, $uid, $username){

        $database = $this->_databaseConnection->connectToDatabase();
        if($database === false){
            return false;
        }

        $sql = $database->prepare("
            INSERT INTO influencer_users(email, password, uid, active, username)
            Values(?, ?, ?, ?, ?)
        ");


        $sql->bind_param("sssis", $a, $b, $c, $d, $e);

        $a = $email;
        $b = $password;
        $c = $uid;
        $d = 1;
        $e = $username;


        $insert = $sql->execute();
        if($insert === true){
            return true;
        }else{
            $this->_monolog->critical('Register new Influencer Value could not be inserted to database', ['exception' => __CLASS__]);
            return false;
        }



    }



}