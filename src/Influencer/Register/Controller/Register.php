<?php
/**
 * Created by PhpStorm.
 * User: kian
 * Date: 02.02.19
 * Time: 00:09
 */

namespace App\Influencer\Register\Controller;


use Symfony\Component\HttpFoundation\JsonResponse;

class Register
{
    protected $_database;

    public function __construct()
    {
        $this->_database = new \App\Influencer\Register\Model\CreateUser();

    }

    public function __invoke(){

        if((!isset($_POST['email'])) || (!isset($_POST['password']))){
            return new JsonResponse([
                'success' => false,
                'content' => 'Not all fields are set'
            ]);
        }


        $email      =   $_POST['email'];
        $password   =   $_POST['password'];
        $uid        =   \App\Influencer\Register\Model\UidGenerator::generateUserId($email);


        $registerUser = $this->_database->createNewInfluencerUser($email, $password, $uid);

        if($registerUser === false){
            return new JsonResponse([
                'success' => false,
                'content' => ''
            ]);
        }


        return new JsonResponse([
            'success' => true,
            'content' => [
                'uid' => $uid
            ]]);
    }

}