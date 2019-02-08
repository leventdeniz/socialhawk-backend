<?php
/**
 * Created by PhpStorm.
 * User: kian
 * Date: 30.01.19
 * Time: 21:18
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class Index
{
    /**
     * @return Response
     */
    public function __invoke(){
        return new Response("There is nothing for you to see here ...");
    }

}