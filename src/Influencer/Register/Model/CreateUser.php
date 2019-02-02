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
    protected $_databaseConnection;

    public function __construct()
    {
        $this->_databaseConnection = new \App\Setup\Database();
    }

    public function createNewInfluencerUser($email, $password, $uid){

        $database = $this->_databaseConnection->connectToDatabase();
        if($database === false){
            return false;
        }

        $sql = $database->prepare("
            INSERT INTO influencer_users(email, password, uid)
            Values(?, ?, ?)
        ");


        $sql->bind_param("sss", $a, $b, $c);

        $a = $email;
        $b = $password;
        $c = $uid;


        $sql->execute();



        return true;
    }



}