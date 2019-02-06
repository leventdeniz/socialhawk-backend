<?php
/**
 * Created by PhpStorm.
 * User: kian
 * Date: 02.02.19
 * Time: 10:59
 */

namespace App\Influencer\Register\Model;


class UidGenerator
{

    //TODO: This needs to be overhauled @kian
    /**
     * @param $email
     * @return string
     */
    public static function generateUserId($email){
        return sha1($email) . rand(0, 999999);
    }

}