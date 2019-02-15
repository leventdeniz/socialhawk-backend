<?php
/**
 * Created by PhpStorm.
 * User: kshahriyari
 * Date: 11.02.19
 * Time: 10:02
 */

namespace App\Influencer\Campaign\Controller;

use App\Influencer\Campaign\Model\AllCampaigns;
use App\System\Core\Helper\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Influencer\UserIdValidation\Model\UserIdValidation;

class Campaigns
{
    /**
     * @var UserIdValidation
     */
    protected $_uidValidation;

    /**
     * @var Request
     */
    protected $_request;

    /**
     * @var AllCampaigns
     */
    protected $_allCampaigns;

    public function __construct()
    {
        $this->_request = new Request();
        $this->_allCampaigns = new AllCampaigns();
        $this->_uidValidation = new UserIdValidation();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function __invoke()
    {

        if (empty($this->_request->getContent())) {
            return JsonResponse::return(false, 'No json content');
        }
        $requestJson = json_decode($this->_request->getContent(), true);

        if (!isset($requestJson['uid'])) {
            return JsonResponse::return(false, 'No uid');
        }
        $uid = $requestJson['uid'];
        $validation = $this->_uidValidation->validateUniqueUserId($uid);

        if ($validation) {
            $recommendation = $this->_allCampaigns->getAllCampaigns();
            if ($recommendation) {
                print_r($recommendation);die();
                return JsonResponse::return(true, $recommendation);
            }
        }

        return JsonResponse::return(false);

    }

}