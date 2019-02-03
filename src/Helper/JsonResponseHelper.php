<?php
/**
 * Created by PhpStorm.
 * User: levent
 * Date: 03.02.19
 * Time: 14:54
 */

namespace App\Helper;


use Symfony\Component\HttpFoundation\JsonResponse;

class JsonResponseHelper
{
    /**
     * @param bool $success
     * @param array $content
     * @return JsonResponse
     */
    public function returnJsonResponse($success, $content)
    {
        return new JsonResponse([
            'success' => (bool)$success,
            'content' => (array)$content
        ]);
    }
}