<?php
/**
 * Created by PhpStorm.
 * User: kshahriyari
 * Date: 10.02.19
 * Time: 12:33
 */

namespace App\Influencer\Profile\Model;

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

    public function getProfileData($uid)
    {
        $database = $this->_databaseConnection->connectToDatabase();
        if ($database === false) {
            return false;
        }

        $sql = $database->prepare("
SELECT 
    influencer_users.username AS username, 
    influencer_users.email AS email, 
    influencer_users.reg_date AS reg_date,
    influencer_instagram.username AS ig_username,
    influencer_instagram.category AS ig_category,
    influencer_instagram.followed_by AS ig_follower_count,
    influencer_instagram.profile_pic_url AS ig_profile_pic_url,
    influencer_instagram.biography AS ig_biography

FROM 
  influencer_users 
    LEFT JOIN influencer_instagram
      ON influencer_instagram.id_influencer = influencer_users.id

WHERE influencer_users.uid=? 
AND influencer_users.active=1
        ");


        $sql->bind_param("s", $a);
        $a = $uid;

        $sql->execute();
        $result = $sql->get_result();

        //user does exist
        if ($result->num_rows === 1) {

            return $result->fetch_assoc();

        } else if ($result->num_rows > 1) {
            //something really wrong happened, UID exist more than once
            //$this->_monolog->error('USER ID / EMAIL EXIST MORE THAN ONCE: ' . $email);
            //todo: add logging @kian
            return false;
        }

        return false;

    }

}