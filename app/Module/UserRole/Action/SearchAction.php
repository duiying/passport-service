<?php

namespace App\Module\UserRole\Action;

use HyperfPlus\Util\Util;
use HyperfPlus\Controller\AbstractController;
use HyperfPlus\Constant\Constant;
use App\Module\UserRole\Logic\UserRoleLogic;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use HyperfPlus\Http\Response;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;

class SearchAction extends AbstractController
{
    /**
     * @Inject()
     * @var UserRoleLogic
     */
    private $logic;

    /**
     * @Inject()
     * @var ValidatorFactoryInterface
     */
    public $validationFactory;

    private $rules = [
        'p'             => 'integer|min:1',
        'size'          => 'integer|min:1',
        'id'            => 'integer',
        'user_id'       => 'integer',
        'role_id'       => 'integer',
        'status'        => 'integer'
    ];

    public function handle(RequestInterface $request, Response $response)
    {
        // 参数校验
        $requestData = $request->all();
        $this->validationFactory->make($requestData, $this->rules)->validate();
        $requestData = Util::sanitize($requestData, $this->rules);

        $p      = isset($requestData['p']) ? $requestData['p'] : Constant::DEFAULT_PAGE;
        $size   = isset($requestData['size']) ? $requestData['size'] : Constant::DEFAULT_SIZE;
        if (isset($requestData['p']))       unset($requestData['p']);
        if (isset($requestData['size']))    unset($requestData['size']);

        $res = $this->logic->search($requestData, $p, $size);
        return $response->success($res);
    }
}