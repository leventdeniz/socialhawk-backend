<?php
/**
 * Created by PhpStorm.
 * User: kian
 * Date: 03.02.19
 * Time: 18:34
 */

namespace App\Influencer\Login\Model;


class LoginUser
{
    /**
     * @var \App\Setup\Database
     */
    protected $_databaseConnection;

    public function __construct()
    {
        $this->_databaseConnection = new \App\Setup\Database();
    }

    public function getUserData($email, $password){

        $database = $this->_databaseConnection->connectToDatabase();
        if($database === false){
            //Todo: Insert logging here @kian
            return false;
        }

        $sql = $database->prepare("
            SELECT uid FROM influencer_users WHERE email=? AND password=? AND active=1
        ");


        $sql->bind_param("ss", $a, $b);
        $a = $email;
        $b = $password;

        $sql->execute();
        $result = $sql->get_result();

        //user does exist
        if($result->num_rows === 1){

            return $result->fetch_all();

        }else if($result->num_rows > 1){
            //something really wrong happend, UID exist more than once
            //TODO Implement logging for that case @kian

            return false;
        }

        return false;
    }

}