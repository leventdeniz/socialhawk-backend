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

    public function getUserRecommendation($uid)
    {

        $database = $this->_databaseConnection->connectToDatabase();
        if ($database === false) {
            return false;
        }

        $sql = $database->prepare("
            SELECT c.campaign_hash      AS campaign_id,
                   a.company_name       AS advertiser,
                   c.campaign_title     AS title,
                   c.campaign_desc      AS description,
                   c.creation_date,
                   c.expiration_date,
                   GROUP_CONCAT(h.tag)  AS hashtags,
                   'https://via.placeholder.com/650x350' as thumbnail,
                   r.type               AS rewards
            FROM campaigns AS c
                   LEFT JOIN campaigns_rewards AS c_r
                             ON c.id = c_r.id_campaign
                   LEFT JOIN rewards AS r
                             ON r.id = c_r.id_rewards
                   LEFT JOIN advertiser_users AS a
                             ON a.id = c.advertiser_id
                   LEFT JOIN campaigns_hashtags AS c_h
                             ON c_h.campagin_id = c.id
                   LEFT JOIN hashtags AS h
                             ON h.id = c_h.hashtag_id
            WHERE c.active = 1
            GROUP BY c.id
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