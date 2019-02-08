<?php
/**
 * Created by PhpStorm.
 * User: kian
 * Date: 02.02.19
 * Time: 00:09
 */

namespace App\Advertiser\Register\Controller;


use App\System\Helper\JsonResponse;
use App\Advertiser\Register\Model\CreateUser;
use App\Advertiser\Register\Model\InfluencerExist;
use App\Advertiser\Register\Model\UidGenerator;
use Symfony\Component\HttpFoundation\Request;

class Register
{
    /**
     * @var CreateUser
     */
    protected $_database;

    /**
     * @var Request
     */
    protected $_request;

    /**
     * @var InfluencerExist
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
        if (empty($this->_request->getContent())) {
            return JsonResponse::return(false);
        }

        $requestJson = json_decode($this->_request->getContent(), true);

        //If body fields are empty
        if (empty($requestJson['email'])
            || empty($requestJson['password'])
            || empty($requestJson['passwordConfirm'])
            || empty($requestJson['company'])
        ) {
            return JsonResponse::return(
                false,
                'Your password, email or username is empty'
            );
        }


        //check if passwords are matching
        if ($requestJson['password'] !== $requestJson['passwordConfirm']) {
            return JsonResponse::return(
                false,
                'Passwords are not matching'
            );
        }

        $email          = $requestJson['email'];
        $password       = $requestJson['password'];
        $companyName    = $requestJson['company'];
        $uid            = UidGenerator::generateUserId($email);

        $checkIfUserExist = $this->_userExist->byCredentials($email, $companyName);

        /**
         * The user does exist, we the user can't sign up
         */
        if ($checkIfUserExist === true) {
            return JsonResponse::return(
                false,
                'E-Mail or Username already exist. Please choose a new one.'
            );
        }

        $registerUser = $this->_database->createNewAdvertiserUser($email, $password, $uid, $companyName);

        if ($registerUser === false) {
            return JsonResponse::return(false);
        }

        return JsonResponse::return(
            true,
            ['uid' => $uid]
        );
    }

}