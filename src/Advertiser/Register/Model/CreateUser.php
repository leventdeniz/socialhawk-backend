<?php
/**
 * Created by PhpStorm.
 * User: kian
 * Date: 02.02.19
 * Time: 11:13
 */

namespace App\Advertiser\Register\Model;


use App\Advertiser\Register\Logger\RegisterLogger;
use App\System\Core\Setup\Database;
use DateTime;
use Exception;

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
    public function createNewAdvertiserUser($email, $password, $uid, $username)
    {

        $database = $this->_databaseConnection->connectToDatabase();
        $date = $this->getDate();
        if ($database === false || $date === false) {
            return false;
        }

        $sql = $database->prepare("
            INSERT INTO advertiser_users(email, password, uid, reg_date, active, company_name)
            Values(?, ?, ?, FROM_UNIXTIME(?), ?, ?)
        ");

        $sql->bind_param("sssiis", $a, $b, $c, $d, $e, $f);

        $a = $email;
        $b = $password;
        $c = $uid;
        $d = $date;
        $e = 1;
        $f = $username;

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

    /**
     * get unix int of current timestamp
     * @return bool|int
     */
    private function getDate()
    {
        try {
            $dateNow = new DateTime();
            return $dateNow->getTimestamp();
        } catch (Exception $e) {
            $this->_monolog->critical(
                $e->getMessage(),
                ['exception' => __CLASS__]
            );
            return false;
        }
    }

}
