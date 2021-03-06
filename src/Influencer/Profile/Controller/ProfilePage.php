<?php
/**
 * Created by PhpStorm.
 * User: kshahriyari
 * Date: 09.02.19
 * Time: 11:06
 */

namespace App\Influencer\Profile\Controller;

use App\System\Core\Helper\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Influencer\UserIdValidation\Model\UserIdValidation;
use App\Influencer\Profile\Model\Profile;

class ProfilePage
{
    /**
     * @var Request
     */
    protected $_request;

    /**
     * @var UserIdValidation
     */
    protected $_uidValidation;

    /**
     * @var Profile
     */
    protected $_profile;

    public function __construct()
    {
        $this->_request         = new Request();
        $this->_uidValidation   = new UserIdValidation();
        $this->_profile         = new Profile();
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
        if ($validate) {

            $getProfileData = $this->_profile->getProfileData($uid);

            /**
             * Something really wrong happened, either the database is down or the user does not exist anymore
             * Then todo: add error logging @kian
             */
            if ($getProfileData === false) {
                return JsonResponse::return(false);
            }

            return JsonResponse::return(true, $getProfileData);
        }

        return JsonResponse::return(false);

    }

}