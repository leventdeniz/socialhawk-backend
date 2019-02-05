<?php
/**
 * Created by PhpStorm.
 * User: kian
 * Date: 02.02.19
 * Time: 00:09
 */

namespace App\Influencer\Register\Controller;


use App\Helper\JsonResponse;
use App\Influencer\Register\Model\CreateUser;
use App\Influencer\Register\Model\InfluencerExist;
use App\Influencer\Register\Model\UidGenerator;
use Symfony\Component\HttpFoundation\Request;

class Register
{
    /**
     * @var \App\Influencer\Register\Model\CreateUser
     */
    protected $_database;

    /**
     * @var Request
     */
    protected $_request;

    /**
     * @var \App\Influencer\Register\Model\InfluencerExist
     */
    protected $_userExist;

    public function __construct()
    {
        $this->_database = new CreateUser();
        $this->_userExist = new InfluencerExist();
        $this->_request = new Request();
    }

    public function __invoke()
    {

        //If request body is empty
        if(empty($this->_request->getContent())){
            return JsonResponse::return(false);
        }

        $requestJson = json_decode($this->_request->getContent(), true);

        //If body fields are empty
        if(empty($requestJson['email']) || empty($requestJson['password'])){
            return JsonResponse::return(
                false,
                'Your password or email is empty'
            );
        }

        $email = $requestJson['email'];
        $password = $requestJson['password'];
        $uid = UidGenerator::generateUserId($email);

        $checkIfUserExist = $this->_userExist->byEmail($email);

        /**
         * The user does exist, we the user can't sign up
         */
        if ($checkIfUserExist === true) {
            return JsonResponse::return(
                false,
                'E-Mail exist'
            );
        }

        $registerUser = $this->_database->createNewInfluencerUser($email, $password, $uid);

        if ($registerUser === false) {
            return JsonResponse::return(false);
        }

        return JsonResponse::return(
            true,
            ['uid' => $uid]
        );
    }

}