<?php
/**
 * Created by PhpStorm.
 * User: kian
 * Date: 02.02.19
 * Time: 00:09
 */

namespace App\Influencer\Register\Controller;


use App\Influencer\Register\Model\CreateUser;
use App\Influencer\Register\Model\InfluencerExist;
use App\Influencer\Register\Model\UidGenerator;
use Symfony\Component\HttpFoundation\JsonResponse;

class Register
{
    /**
     * @var \App\Influencer\Register\Model\CreateUser
     */
    protected $_database;

    /**
     * @var \App\Influencer\Register\Model\InfluencerExist
     */
    protected $_userExist;

    public function __construct()
    {
        $this->_database = new CreateUser();
        $this->_userExist = new InfluencerExist();

    }

    public function __invoke()
    {

        if ((!isset($_POST['email'])) || (!isset($_POST['password']))) {
            return new JsonResponse([
                'success' => false,
                'content' => 'Not all fields are set'
            ]);
        }

        $email = $_POST['email'];
        $password = $_POST['password'];
        $uid = UidGenerator::generateUserId($email);

        $checkIfUserExist = $this->_userExist->byEmail($email);

        /**
         * The user does exist, we the user can't sign up
         */
        if ($checkIfUserExist === true) {
            return new JsonResponse([
                'success' => false,
                'content' => 'E-Mail exist'
            ]);
        }

        $registerUser = $this->_database->createNewInfluencerUser($email, $password, $uid);

        if ($registerUser === false) {
            return new JsonResponse([
                'success' => false,
                'content' => ''
            ]);
        }

        return new JsonResponse([
                'success' => true,
                'content' => [
                    'uid' => $uid
                ]]
        );
    }

}