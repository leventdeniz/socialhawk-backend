<?php
/**
 * Created by PhpStorm.
 * User: kian
 * Date: 03.02.19
 * Time: 13:42
 */

namespace App\Advertiser\Register\Model;


use App\System\Setup\Database;

class InfluencerExist
{
    /**
     * @var Database
     */
    protected $_databaseConnection;

    /**
     * InfluencerExist constructor.
     */
    public function __construct()
    {
        $this->_databaseConnection = new Database();
    }

    /**
     * @param $email
     * @return bool
     */
    public function byEmail($email)
    {

        $database = $this->_databaseConnection->connectToDatabase();
        if ($database === false) {
            return false;
        }

        $sql = $database->prepare("
            SELECT * FROM influencer_users WHERE email=?
        ");


        $sql->bind_param("s", $a);
        $a = $email;

        $sql->execute();
        $result = $sql->get_result();

        /**
         * User does not exist, so we return false
         * Else we return true, the user does exist.
         */
        if ($result->num_rows === 0) {
            return false;
        }

        return true;


    }

    /**
     * @param $email
     * @param $company
     * @return bool
     */
    public function byCredentials($email, $company)
    {

        $database = $this->_databaseConnection->connectToDatabase();
        if ($database === false) {
            return false;
        }

        $sql = $database->prepare("
            SELECT * FROM advertiser_users WHERE email=? OR company_name=?
        ");


        $sql->bind_param("ss", $a, $b);
        $a = $email;
        $b = $company;

        $sql->execute();
        $result = $sql->get_result();

        /**
         * User does not exist, so we return false
         * Else we return true, the user does exist.
         */
        if ($result->num_rows === 0) {
            return false;
        }

        return true;
    }

}