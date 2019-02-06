<?php
/**
 * Created by PhpStorm.
 * User: kian
 * Date: 02.02.19
 * Time: 11:13
 */

namespace App\Influencer\Register\Model;


use App\Influencer\Register\Logger\RegisterLogger;
use App\Setup\Database;

class CreateUser
{
    /**
     * @var Database
     */
    protected $_databaseConnection;

    /**
     * @var RegisterLogger
     */
    protected $_monolog;

    public function __construct()
    {
        $this->_databaseConnection = new Database();
        $this->_monolog = new RegisterLogger();
    }

    /**
     * @param $email
     * @param $password
     * @param $uid
     * @param $username
     * @return bool
     */
    public function createNewInfluencerUser($email, $password, $uid, $username)
    {

        $database = $this->_databaseConnection->connectToDatabase();
        if ($database === false) {
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
        if ($insert === true) {
            return true;
        } else {
            $this->_monolog->critical(
                'Register new Influencer Value could not be inserted to database',
                ['exception' => __CLASS__]
            );
            return false;
        }

    }

}
