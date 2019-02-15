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
     * @param bool $prepare
     * @return array|bool|mixed
     */
    public function getAllCampaigns($prepare = true)
    {
        $database = $this->_databaseConnection->connectToDatabase();
        if ($database === false) {
            return false;
        }

        //Todo: change thumbnail when implemented @levent
        $sql =  "
SELECT
    campaigns.campaign_url_hash AS campaign_hash,
    campaigns.campaign_title AS title,
    campaigns.campaign_desc AS description,
    campaigns.creation_date,
    campaigns.expiration_date,
    GROUP_CONCAT(hashtags.tag) AS hashtags,
    'https://via.placeholder.com/650x350' as thumbnail,
    rewards.type AS rewards

    
FROM
    campaigns
    LEFT JOIN campaigns_rewards ON campaigns.id = campaigns_rewards.id_campaign
    LEFT JOIN rewards ON rewards.id = campaigns_rewards.id_rewards
    LEFT JOIN advertiser_users ON advertiser_users.id = campaigns.advertiser_id
    LEFT JOIN campaigns_hashtags ON campaigns_hashtags.campagin_id = campaigns.id
    LEFT JOIN hashtags ON hashtags.id = campaigns_hashtags.hashtag_id
WHERE
    campaigns.active = 1
GROUP BY
	campaigns.id;
";
        $result = $database->query($sql);

        if ($result->num_rows > 0) {

            if($prepare){
                return $this->prepareDbResultForFrontend($result->fetch_all());
            }

            return $result->fetch_all();
        }

        return false;
    }

    /**
     * This method will map the fields that we need so the frontend can work with a decent
     * dataset.
     *
     * @param $dbArray
     * @return array
     */
    private function prepareDbResultForFrontend($dbArray){

        $returnArray = [];
        foreach ($dbArray as $row){

            $returnArray[] =  [
                'campaign_id' => $row[0],
                'company' => 'Edeka',
                'campaign_title' => $row[1],
                'campaign_desc' => $row[2],
                'campaign_creation_date' => 'xx.xx.xx',
                'campaign_expiration_date' => 'yy.yy.xx',
                'campaign_hashtags' =>  $row[5],
                'campaign_thumbnail' => $row[6],
                'reward' => '100€'
            ];
        }

        print_r($returnArray);

        die();

        return $returnArray;
    }

}