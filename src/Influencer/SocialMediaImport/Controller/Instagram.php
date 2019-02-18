<?php
/**
 * Created by PhpStorm.
 * User: kshahriyari
 * Date: 11.02.19
 * Time: 17:15
 */

namespace App\Influencer\SocialMediaImport\Controller;

use App\System\Core\Helper\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Influencer\UserIdValidation\Model\UserIdValidation;
use App\Influencer\SocialMediaImport\Model\InstagramImport;

class Instagram
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
     * @var InstagramImport
     */
    protected $_instagramImport;

    public function __construct()
    {
        $this->_request         = new Request();
        $this->_uidValidation   = new UserIdValidation();
        $this->_instagramImport = new InstagramImport();
    }

    public function __invoke()
    {
        if (empty($this->_request->getContent())) {
            return JsonResponse::return(false);
        }

        $requestJson = json_decode($this->_request->getContent(), true);

        $uid        = $requestJson['uid'];
        $igName     = $requestJson['username'];

        $validate = $this->_uidValidation->validateUniqueUserId($uid);
        if($validate) {

            $importData = $this->_instagramImport->importUser($uid, $igName);

            if($importData){
                return JsonResponse::return(true);
            }

        }


        return JsonResponse::return(false);
    }

}