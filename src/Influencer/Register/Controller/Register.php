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



        //These are currently just mock datas, so we can work
        return new JsonResponse([
            'success' => true,
            'content' => [
                'uid' => 1337
            ]]);
    }

}