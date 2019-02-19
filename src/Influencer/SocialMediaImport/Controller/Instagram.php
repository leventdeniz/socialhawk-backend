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
            return JsonResponse::return(
                false,
                'No JSON request content'
            );
        }

        $requestJson = json_decode($this->_request->getContent(), true);

        $uid = $requestJson['uid'];
        $igName = $requestJson['igUsername'];

        $validate = $this->_uidValidation->validateUniqueUserId($uid);
        if ($validate) {

            $importData = $this->_instagramImport->importUser($uid, $igName);

            /**
             * If everything is alright, we get a success -> true
             */
            if ($importData['success']) {
                return JsonResponse::return(
                    $importData['success'],
                    $importData['content']
                );
            }

            /**
             * Something went wront, so we deliver success -> false and the message of the error
             */
            return JsonResponse::return(
                $importData['success'],
                $importData['content']
            );

        }

        return JsonResponse::return(
            false,
            'User does not exist'
        );
    }

}