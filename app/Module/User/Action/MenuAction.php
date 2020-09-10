<?php

namespace App\Module\User\Action;

use App\Module\User\Logic\UserLogic;
use HyperfPlus\Util\Util;
use HyperfPlus\Controller\AbstractController;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use HyperfPlus\Http\Response;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;

class MenuAction extends AbstractController
{
    /**
     * @Inject()
     * @var UserLogic
     */
    private $logic;

    /**
     * @Inject()
     * @var ValidatorFactoryInterface
     */
    public $validationFactory;

    private $rules = [
        'user_id' => 'required|integer'
    ];

    public function handle(RequestInterface $request, Response $response)
    {
        // 参数校验
        $requestData = $request->all();
        $this->validationFactory->make($requestData, $this->rules)->validate();
        $requestData = Util::sanitize($requestData, $this->rules);

        $res = $this->logic->getUserMenuList($requestData);
        return $response->success($res);
    }
}