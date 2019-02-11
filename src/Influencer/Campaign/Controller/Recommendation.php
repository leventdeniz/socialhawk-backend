<?php
/**
 * Created by PhpStorm.
 * User: kshahriyari
 * Date: 11.02.19
 * Time: 10:02
 */

namespace App\Influencer\Campaign\Controller;

use App\System\Core\Helper\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Influencer\UserIdValidation\Model\UserIdValidation;

class Recommendation
{
    /**
     * @var UserIdValidation
     */
    protected $_uidValidation;

    /**
     * @var Request
     */
    protected $_request;

    public function __construct()
    {
        $this->_request         = new Request();
        $this->_uidValidation   = new UserIdValidation();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function __invoke()
    {
        if (empty($this->_request->getContent())) {
            return JsonResponse::return(false);
        }

        $requestJson = json_decode($this->_request->getContent(), true);
        $uid = $requestJson['uid'];

        $validate = $this->_uidValidation->validateUniqueUserId($uid);
        if($validate){

            $recommmendation = [

                [
                    'company' => 'Edeka',
                    'title' => 'Euterpflege',
                    'desc' => 'lorem ipsum dolor sit amte autem, lorem ipsum dolor sit amte autem',
                    'id' => '1337'
                ]

            ];

            return JsonResponse::return(true, $recommmendation);
        }

        return JsonResponse::return(false);

    }

}