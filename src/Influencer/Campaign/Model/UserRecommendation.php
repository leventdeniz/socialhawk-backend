<?php
/**
 * Created by PhpStorm.
 * User: kshahriyari
 * Date: 11.02.19
 * Time: 11:17
 */

namespace App\Influencer\Campaign\Model;

use App\System\Core\Setup\Database;

class UserRecommendation
{
    /**
     * @var Database
     */
    protected $_databaseConnection;

    public function __construct()
    {
        $this->_databaseConnection = new Database();
    }

    public function getUserRecommendation($uid){

        $database = $this->_databaseConnection->connectToDatabase();
        if ($database === false) {
            return false;
        }

        $sql = $database->prepare("
            SELECT campaigns.id, campaigns.campaign_id, campaigns.campaign_title, campaigns.campaign_desc,  campaigns_reward.id_rewards FROM campaigns 
            LEFT JOIN campaigns ON campaigns_reward.id_rewards = campaigns.id  
            
            WHERE campaigns.active=1
        ");


        //$sql->bind_param("ss", $a, $b);
        //$a = $uid;

        $sql->execute();
        $result = $sql->get_result();

        //user does exist
        if ($result->num_rows > 0) {

            return $result->fetch_all();
        }

        return false;

    }

}