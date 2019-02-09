<?php
/**
 * Created by PhpStorm.
 * User: levent
 * Date: 05.02.19
 * Time: 11:10
 */

namespace App\Influencer\UserIdValidation\Controller;


use App\System\Core\Helper\JsonResponse;
use App\Influencer\UserIdValidation\Model\UserIdValidation as UserIdValidationModel;
use App\System\Core\Setup\Database;
use Symfony\Component\HttpFoundation\Request;

class UserIdValidate
{
    /**
     * @var Database
     */
    protected $_database;

    /**
     * @var Request
     */
    protected $_request;

    /**
     * @var UserIdValidationModel
     */
    protected $_validator;

    /**
     * UserIdValidate constructor.
     */
    public function __construct()
    {
        $this->_database    = new Database();
        $this->_request     = new Request();
        $this->_validator   = new UserIdValidationModel();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function __invoke()
    {
        if (empty($this->_request->getContent())) {
            return JsonResponse::return(false);
        }

        $requestJson    = json_decode($this->_request->getContent(), true);
        $uid            = $requestJson['uid'];
        if (empty($uid)) {
            return JsonResponse::return(false);
        }

        $validUserId = $this->_validator->validateUniqueUserId($uid);
        if ($validUserId) {
            return JsonResponse::return(true);
        } else {
            return JsonResponse::return(false);
        }
    }
}