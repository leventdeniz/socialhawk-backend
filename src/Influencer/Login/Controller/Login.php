<?php
/**
 * Created by PhpStorm.
 * User: kian
 * Date: 01.02.19
 * Time: 23:31
 */

namespace App\Influencer\Login\Controller;


use App\Helper\JsonResponse;

class Login
{
    protected $_loginUser;

    public function __construct()
    {
        $this->_loginUser = new \App\Influencer\Login\Model\LoginUser();
    }


    public function __invoke(){

        if ((!isset($_POST['email'])) || (!isset($_POST['password']))) {
            return JsonResponse::returnJsonResponse(
                false,
                ''
            );
        }

        $email      =   $_POST['email'];
        $password   =   $_POST['password'];

        //if the user exist, we get the UID, else we get bool
        $getUid = $this->_loginUser->getUserData($email, $password);


var_dump($getUid);die();


    }

}