<?php
/**
 * Created by PhpStorm.
 * User: kian
 * Date: 02.02.19
 * Time: 00:09
 */

namespace App\Influencer\Register\Controller;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Register extends Request
{

    public function __invoke(){

        if((!isset($_POST['email'])) || (!isset($_POST['password']))){
            return new JsonResponse([
                'success' => false,
                'content' => 'Not all fields are set'
            ]);
        }


        $email      = $_POST['email'];
        $password   = $_POST['password'];
        $uid        = \App\Influencer\Register\Model\UidGenerator::generateUserId($email);


        //These are currently just mock datas, so we can work
        return new JsonResponse([
            'success' => true,
            'content' => [
                'uid' => $uid
            ]]);
    }

}