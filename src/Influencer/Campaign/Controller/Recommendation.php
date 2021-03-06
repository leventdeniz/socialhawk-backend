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
     * @var Request
     */
    protected $_request;

    /**
     * @var UserRecommendation
     */
    protected $_userRecommendation;

    public function __construct()
    {
        $this->_request             = new Request();
        $this->_uidValidation       = new UserIdValidation();
        $this->_userRecommendation  = new UserRecommendation();
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


            //$recommendation = $this->_userRecommendation->getUserRecommendation($uid);
            //TODO: This needs to be fixed, currently the 'getUserRecommendation' is not working
            $recommendation = $this->_userRecommendation->getAllCampaigns();
            //print_r($recommendation);die();
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