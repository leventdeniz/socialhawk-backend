<?php
/**
 * Created by PhpStorm.
 * User: kian
 * Date: 30.01.19
 * Time: 21:18
 */

namespace App\Influencer\Index\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class Ajax
{
    /**
     * @return Response
     */
    public function __invoke(){
        return new JsonResponse(['success' => 'it has worked!']);
    }

}