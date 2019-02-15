<?php
/**
 * Created by PhpStorm.
 * User: levent
 * Date: 15.02.19
 * Time: 09:39
 */

namespace App\Influencer\Campaign\Model;

use App\System\Core\Setup\Database;

class AllCampaigns
{
    /**
     * @var Database
     */
    protected $_databaseConnection;

    public function __construct()
    {
        $this->_databaseConnection = new Database();
    }

    /**
     * @return bool|mixed
     */
    public function getAllCampaigns()
    {
        $database = $this->_databaseConnection->connectToDatabase();
        if ($database === false) {
            return false;
        }

        //Todo: change thumbnail when implemented @levent
        $sql =  $database->query("
SELECT
  c.campaign_url_hash AS campaign_hash,
  a.company_name AS advertiser,
  c.campaign_title AS title,
  c.campaign_desc AS description,
  c.creation_date,
  c.expiration_date,
  GROUP_CONCAT(h.tag) AS hashtags,
  'https://via.placeholder.com/650x350' as thumbnail,
  r.type AS rewards
FROM
  campaigns AS c
  LEFT JOIN campaigns_rewards AS c_r ON c.id = c_r.id_campaign
  LEFT JOIN rewards AS r ON r.id = c_r.id_rewards
  LEFT JOIN advertiser_users AS a ON a.id = c.advertiser_id
  LEFT JOIN campaigns_hashtags AS c_h ON c_h.campagin_id = c.id
  LEFT JOIN hashtags AS h ON h.id = c_h.hashtag_id
WHERE
  c.active = 1
GROUP BY
  c.id;
");



        $sql->execute();
        $result = $sql->get_result();

        //user does exist
        if ($result->num_rows > 0) {

            return $result->fetch_all();
        }

        return false;
    }

}