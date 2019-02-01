<?php
/**
 * Created by PhpStorm.
 * User: kian
 * Date: 01.02.19
 * Time: 23:31
 */

namespace App\Influencer\Login\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;


class Login
{
    /**
     * @return JsonResponse
     */
    public function __invoke(){

        return new JsonResponse(['success' => false, 'content' => '']);
    }

}