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

    /**
     * @param $uid
     * @param $instaAccountName
     * @return bool
     */
    public function importUser($uid, $instaAccountName)
    {
        $database = $this->_databaseConnection->connectToDatabase();
        if ($database === false) {
            return false;
        }

        $userId = $this->getUserIdByUid($uid);

        //user does exist
        if ($userId > 0) {

            $instaData = $this->fetchIgAccountJson($instaAccountName);

            $sql = $database->prepare("
            INSERT INTO influencer_instagram(id_influencer, username, biography, followed_by, category, profile_pic_url, full_name)
            Values(?, ?, ?, ?, ?, ?,?)
        ");

            $sql->bind_param("ississs", $a, $b, $c, $d, $e, $f, $g);

            $a = $userId;
            $b = $instaData['graphql']['user']['username'];
            $c = $instaData['graphql']['user']['biography'];
            $d = $instaData['graphql']['user']['edge_followed_by']['count'];
            $e = $instaData['graphql']['user']['business_category_name'];
            $f = $instaData['graphql']['user']['profile_pic_url'];
            $g = $instaData['graphql']['user']['full_name'];

            $insert = $sql->execute();
            if ($insert === true) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $username
     * @return mixed
     */
    public function fetchIgAccountJson($username)
    {
        $url     = sprintf("https://www.instagram.com/$username");
        $content = file_get_contents($url);
        $content = explode("window._sharedData = ", $content)[1];
        $content = explode(";</script>", $content)[0];
        $data    = json_decode($content, true);
        return $data['entry_data']['ProfilePage'][0];
    }

    /**
     * @param $uid
     * @return int
     */
    private function getUserIdByUid($uid)
    {
        $id = 0;
        $database = $this->_databaseConnection->connectToDatabase();
        if ($database === false) {
            return $id;
        }

        $sql = $database->prepare("
            SELECT id FROM influencer_users WHERE uid=? AND active=1
        ");

        $sql->bind_param("s", $a);
        $a = $uid;

        $sql->execute();
        $result = $sql->get_result();

        if ($result->num_rows === 1) {

            $id = $result->fetch_all();
            $id = (int)$id[0][0];
        }
        return $id;
    }


}