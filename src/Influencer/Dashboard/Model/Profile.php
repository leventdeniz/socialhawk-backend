<?php
/**
 * Created by PhpStorm.
 * User: kshahriyari
 * Date: 10.02.19
 * Time: 12:33
 */

namespace App\Influencer\Dashboard\Model;

use App\System\Core\Setup\Database;

class Profile
{
    /**
     * @var Database
     */
    protected $_databaseConnection;

    public function __construct()
    {
        $this->_databaseConnection = new Database();
    }

    public function getProfileData($uid){
        $database = $this->_databaseConnection->connectToDatabase();
        if ($database === false) {
            return false;
        }

        $sql = $database->prepare("
            SELECT username, email, reg_date FROM influencer_users WHERE uid=? AND active=1
        ");


        $sql->bind_param("s", $a);
        $a = $uid;

        $sql->execute();
        $result = $sql->get_result();

        //user does exist
        if ($result->num_rows === 1) {

            return $result->fetch_all();

        } else if ($result->num_rows > 1) {
            //something really wrong happened, UID exist more than once
            //$this->_monolog->error('USER ID / EMAIL EXIST MORE THAN ONCE: ' . $email);
            return false;
        }

        return false;

    }

}