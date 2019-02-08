<?php
/**
 * Created by PhpStorm.
 * User: kian
 * Date: 03.02.19
 * Time: 18:34
 */

namespace App\Influencer\Login\Model;


use App\Influencer\Login\Logger\LoginLogger;
use App\System\Setup\Database;

class LoginUser
{
    /**
     * @var Database
     */
    protected $_databaseConnection;

    /**
     * @var LoginLogger
     */
    protected $_monolog;

    public function __construct()
    {
        $this->_databaseConnection = new Database();
        $this->_monolog = new LoginLogger();
    }

    /**
     * @param $email
     * @param $password
     * @return bool|mixed
     */
    public function getUserData($email, $password)
    {

        $database = $this->_databaseConnection->connectToDatabase();
        if ($database === false) {
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
        if ($result->num_rows === 1) {

            return $result->fetch_all();

        } else if ($result->num_rows > 1) {
            //something really wrong happened, UID exist more than once
            $this->_monolog->error('USER ID / EMAIL EXIST MORE THAN ONCE: ' . $email);
            return false;
        }

        return false;
    }

}