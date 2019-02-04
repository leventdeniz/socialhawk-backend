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

    protected $_monolog;

    public function __construct()
    {
        $this->_databaseConnection = new \App\Setup\Database();
        $this->_monolog = new \App\Influencer\Register\Logger\Monolog();
    }

    public function createNewInfluencerUser($email, $password, $uid){

        $database = $this->_databaseConnection->connectToDatabase();
        if($database === false){
            //Todo: Insert logging here @kian
            return false;
        }

        $sql = $database->prepare("
            INSERT INTO influencer_users(email, password, uid, active)
            Values(?, ?, ?, ?)
        ");


        $sql->bind_param("sssi", $a, $b, $c, $d);

        $a = $email;
        $b = $password;
        $c = $uid;
        $d = 1;


        $insert = $sql->execute();
        if($insert === true){
            return true;
        }else{
            $this->_monolog->critical('Register new Influencer Value could not be inserted to database', ['exception' => __CLASS__]);
            return false;
        }



    }



}