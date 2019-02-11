<?php
/**
 * Created by PhpStorm.
 * User: kshahriyari
 * Date: 11.02.19
 * Time: 17:20
 */

namespace App\Influencer\SocialMediaImport\Model;

use App\System\Core\Setup\Database;

class InstagramImport
{
    /**
     * @var Database
     */
    protected $_databaseConnection;

    public function __construct()
    {
        $this->_databaseConnection = new Database();
    }

    public function getIgAccountJson($username){
        $url = sprintf("https://www.instagram.com/$username");
        $content = file_get_contents($url);
        $content = explode("window._sharedData = ", $content)[1];
        $content = explode(";</script>", $content)[0];
        $data = json_decode($content, true);
        return $data['entry_data']['ProfilePage'][0];
    }

    public function importUser($uid, $instaAccountName){

        $database = $this->_databaseConnection->connectToDatabase();
        if ($database === false) {
            return false;
        }

        $sql = $database->prepare("
            SELECT id FROM influencer_users WHERE uid=? AND active=1
        ");


        $sql->bind_param("s", $a);
        $a = $uid;

        $sql->execute();
        $result = $sql->get_result();

        //user does exist
        if ($result->num_rows === 1) {

            $id =  $result->fetch_all();
            $id = $id[0][0];

            $instaData = $this->getIgAccountJson($instaAccountName);

            /*

                $instaData['graphql']['user']['biography']
                $instaData['graphql']['user']['username']
                $instaData['graphql']['user']['edge_followed_by']['count']
                $instaData['graphql']['user']['business_category_name']
                $instaData['graphql']['user']['profile_pic_url']

            */


            $sql = $database->prepare("
            INSERT INTO influencer_instagram(id_influencer, username, biography, followed_by, category, profile_pic_url)
            Values(?, ?, ?, ?, ?, ?)
        ");

            $sql->bind_param("ississ", $a, $b, $c, $d, $e, $f);

            $a = $id;
            $b = $instaData['graphql']['user']['username'];
            $c = $instaData['graphql']['user']['biography'];
            $d = $instaData['graphql']['user']['edge_followed_by']['count'];
            $e = $instaData['graphql']['user']['business_category_name'];
            $f = $instaData['graphql']['user']['profile_pic_url'];

            $insert = $sql->execute();
            if ($insert === true) {
                return true;
            }
        }


        return false;
    }

}