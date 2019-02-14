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
use App\Influencer\Campaign\Model\UserRecommendation;

class Recommendation
{
    /**
     * @var UserIdValidation
     */
    protected $_uidValidation;

    /**
     * ALL      -> all campaigns available
     * FOLLOWED -> only campaigns the user is following
     *
     * @var string
     */
    protected $_currentRecommendationMode = 'ALL';

    /**
     * @var Request
     */
    protected $_request;

    /**
     * @var UserRecommendation
     */
    protected $_userRecommendation;

    public function __construct()
    {
        $this->_request = new Request();
        $this->_uidValidation = new UserIdValidation();
        $this->_userRecommendation = new UserRecommendation();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function __invoke()
    {
        //Todo: refactor this
        // on should be called via:
        // BASE_URL/campaigns with GET -> return all
        // BASE_URL/campaigns with POST -> post uid and return only followed campaigns
        $validate = false;
        //var_dump($this->_request->getMethod());
        //die();
        if ($this->_request->isMethod('POST') ) {
            if (empty($this->_request->getContent())) {
                return JsonResponse::return(false);
            }
            $requestJson = json_decode($this->_request->getContent(), true);
            if (!isset($requestJson['uid'])) {
                return JsonResponse::return(false,'No uid given');
            }
            $uid = $requestJson['uid'];
            $validate = $this->_uidValidation->validateUniqueUserId($uid);
            $this->_currentRecommendationMode = 'FOLLOWED';
        }

        if ($validate || $this->_currentRecommendationMode == 'ALL') {

            switch ($this->_currentRecommendationMode) {
                case 'FOLLOWED':
                    $recommendation = $this->_userRecommendation->getUserRecommendation($uid);
                    break;
                case 'ALL':
                default:
                $recommendation = $this->_userRecommendation->getAllCampaigns();
            }
            print_r($recommendation);die();
            /*
                        $recommmendation = [

                            [
                                'campaign_id' => '1337',
                                'company' => 'Edeka',
                                'campaign_title' => 'Demo Campaign',
                                'campaign_desc' => 'lorem ipsum dolor sit amte autem, lorem ipsum dolor sit amte autem',
                                'campaign_creation_date' => 'xx.xx.xx',
                                'campaign_expiration_date' => 'yy.yy.xx',
                                'campaign_hashtags' => ['beauty', 'new', 'freshsmell', 'stuff'],
                                'campaign_thumbnail' => 'https://via.placeholder.com/650x350',
                                'reward' => '100€'
                            ],


                            [
                                'campaign_id' => '2337',
                                'company' => 'Addidas',
                                'campaign_title' => 'Addi Demo Campaign',
                                'campaign_desc' => 'lorem ipsum dolor sit amte autem, lorem ipsum dolor sit amte autem',
                                'campaign_creation_date' => 'xx.xx.xx',
                                'campaign_expiration_date' => 'yy.yy.xx',
                                'campaign_hashtags' => ['shoe', 'sport', 'trendy', 'unisex'],
                                'campaign_thumbnail' => 'https://via.placeholder.com/650x350',
                                'reward' => '100€'
                            ],

                            [
                                'campaign_id' => '3337',
                                'company' => 'BMW',
                                'campaign_title' => 'BMW Demo Campaign',
                                'campaign_desc' => 'lorem ipsum dolor sit amte autem, lorem ipsum dolor sit amte autem',
                                'campaign_creation_date' => 'xx.xx.xx',
                                'campaign_expiration_date' => 'yy.yy.xx',
                                'campaign_hashtags' => ['3er', 'Neu', 'AMK', 'BMW'],
                                'campaign_thumbnail' => 'https://via.placeholder.com/650x350',
                                'reward' => '100€'
                            ]

                        ];
            */
            return JsonResponse::return(true, $recommendation);
        }

        return JsonResponse::return(false);

    }

}