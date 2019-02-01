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
    public function __invoke(){

        return new JsonResponse(['success' => false, 'content' => '']);
    }

}