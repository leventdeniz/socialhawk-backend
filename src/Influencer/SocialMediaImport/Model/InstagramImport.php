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

    const RESPONSE_DATABASE_FAILURE = 'Technical problems';

    const RESPONSE_INSTAGRAM_ACCOUNT_NOT_EXIST = 'Account does not exist';

    const RESPONSE_INSTAGRAM_ACCOUNT_IS_PRIVATE = 'Your account is private';

    const RESPONSE_INSTAGRA_ACCOUNT_EXIST_IN_TABLE = 'Instagram account already exist';

    const RESPONSE_IMPORT_SUCCESS = 'Import success';

    const RESPONSE_USER_NOT_EXIST = 'User does not exist';


    public function __construct()
    {
        $this->_databaseConnection = new Database();
    }


    /**
     * @param $instaName
     * @return bool
     */
    private function checkIfInstaAccountExist($instaName)
    {

        $database = $this->_databaseConnection->connectToDatabase();

        $sql = $database->prepare("
            SELECT username FROM influencer_instagram WHERE username=?
        ");

        $sql->bind_param("s", $a);
        $a = $instaName;

        $sql->execute();
        $result = $sql->get_result();

        //user does exist
        if ($result->num_rows === 1) {
            return true;
        }
        return false;
    }


    public function importUser($uid, $instaAccountName)
    {
        $database = $this->_databaseConnection->connectToDatabase();
        if ($database === false) {
            return ['success' => false, 'content' => self::RESPONSE_DATABASE_FAILURE];
        }

        $userId = $this->getUserIdByUid($uid);

        //user does exist
        if ($userId > 0) {

            $instaData = $this->fetchIgAccountJson($instaAccountName);

            /**
             * If the user account does not exist, instagram will return a 404 status.
             */
            if (!$instaData) {
                return ['success' => false, 'content' => self::RESPONSE_INSTAGRAM_ACCOUNT_NOT_EXIST];
            }

            /**
             * Check of the user account is private or not.
             */
            if ($instaData['graphql']['user']['is_private'] == true) {
                return ['success' => false, 'content' => self::RESPONSE_INSTAGRAM_ACCOUNT_IS_PRIVATE];
            }

            /**
             * Check if there is already a user with the same account
             */
            if ($this->checkIfInstaAccountExist($instaAccountName)) {
                return ['success' => false, 'content' => self::RESPONSE_INSTAGRA_ACCOUNT_EXIST_IN_TABLE];
            }

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
                return ['success' => true, 'content' => self::RESPONSE_IMPORT_SUCCESS];
            }
        }

        return ['success' => false, 'content' => self::RESPONSE_USER_NOT_EXIST];
    }

    /**
     * @param $username
     * @return mixed
     */
    public function fetchIgAccountJson($username)
    {
        $url = sprintf("https://www.instagram.com/$username");

        try {
            $content = file_get_contents($url);
        } catch (\Exception $e) {
            return false;
        }

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