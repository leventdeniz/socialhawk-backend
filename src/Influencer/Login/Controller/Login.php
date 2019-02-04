<?php
/**
 * Created by PhpStorm.
 * User: kian
 * Date: 01.02.19
 * Time: 23:31
 */

namespace App\Influencer\Login\Controller;


use App\Helper\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Login
{
    /**
     * @var \App\Influencer\Login\Model\LoginUser
     */
    protected $_loginUser;

    protected $_request;

    public function __construct()
    {
        $this->_loginUser = new \App\Influencer\Login\Model\LoginUser();
        $this->_request = new Request();
    }


    public function __invoke(){


        if(empty($this->_request->getContent())){
            return JsonResponse::returnJsonResponse(
                false,
                ''
            );
        }

        $requestJson = json_decode($this->_request->getContent(), true);

        $email      =   $requestJson['email'];
        $password   =   $requestJson['password'];

        //if the user exist, we get the UID, else we get bool
        $getUid = $this->_loginUser->getUserData($email, $password);
        if($getUid === false){
            return JsonResponse::returnJsonResponse(
                false,
                'Username or password wrong'
            );
        }

        return JsonResponse::returnJsonResponse(
            true,
            $getUid[0][0]
        );


    }

}