<?php
/**
 * Created by PhpStorm.
 * User: kian
 * Date: 01.02.19
 * Time: 23:31
 */

namespace App\Advertiser\Login\Controller;


use App\System\Core\Helper\JsonResponse;
use App\Advertiser\Login\Model\LoginUser;
use Symfony\Component\HttpFoundation\Request;

class Login
{
    /**
     * @var LoginUser
     */
    protected $_loginUser;

    /**
     * @var Request
     */
    protected $_request;

    public function __construct()
    {
        $this->_loginUser = new LoginUser();
        $this->_request = new Request();
    }

    public function __invoke()
    {
        
        if (empty($this->_request->getContent())) {
            return JsonResponse::return(false);
        }

        $requestJson = json_decode($this->_request->getContent(), true);

        $email      =   $requestJson['email'];
        $password   =   $requestJson['password'];

        //if the user exist, we get the UID, else we get bool
        $getUid = $this->_loginUser->getUserData($email, $password);
        if ($getUid === false) {
            return JsonResponse::return(
                false,
                'Username or password wrong'
            );
        }

        return JsonResponse::return(
            true,
            $getUid[0][0]
        );

    }

}