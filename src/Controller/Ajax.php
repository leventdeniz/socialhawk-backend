<?php
/**
 * Created by PhpStorm.
 * User: kian
 * Date: 30.01.19
 * Time: 21:18
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Ajax
{
    /**
     * @return Response
     */
    public function __invoke(){


        $test = new Request();
        $content = $test->getContent();

        //var_dump($content);

        return new JsonResponse(['your_json_string' => $content]);
    }

}