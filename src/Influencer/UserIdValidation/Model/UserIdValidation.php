<?php
/**
 * Created by PhpStorm.
 * User: levent
 * Date: 05.02.19
 * Time: 11:32
 */

namespace App\Influencer\UserIdValidation\Model;


use App\Influencer\UserIdValidation\Logger\Monolog;
use App\Setup\Database;

class UserIdValidation
{
    /**
     * @var Database
     */
    protected $_database;

    /**
     * @var Monolog
     */
    protected $_monolog;

    /**
     * UserIdValidate constructor.
     */
    public function __construct()
    {
        $this->_database = new Database();
        $this->_monolog = new Monolog();
    }

    /**
     * @param $userId
     * @return bool
     */
    public function validateUniqueUserId($userId)
    {
        $connection = $this->_database->connectToDatabase();

        if ($connection == false) {
           return false;
        } else if (empty($userId)) {
            $this->_monolog->error(
                'No unique user Id on method call provided.',
                ['exception' => __CLASS__]
            );
            return false;
        }

        $sql = $connection->prepare("
        SELECT COUNT(1) FROM influencer_users WHERE uid=? AND active=1
        ");

        $sql->bind_param("s", $a);
        $a = $userId;

        $sql->execute();
        $result = $sql->get_result();

        if ($result === 0) {
            return false;
        } else if ($result > 1) {
            $this->_monolog->error(
                'Unique user identification string could not be verified, more than 1 matches for ' . $userId,
                ['exception' => __CLASS__]
            );
            return false;
        } else {
            return true;
        }
    }
}