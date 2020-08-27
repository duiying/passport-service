<?php

namespace App\Module\User\Action;

use HyperfPlus\Controller\AbstractController;
use App\Module\User\Logic\UserLogic;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use HyperfPlus\Http\Response;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;

class FindAction extends AbstractController
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
        'id'            => 'integer',
        'name'          => 'string',
        'email'         => 'string',
        'mobile'        => 'string',
        'position'      => 'string',
        'password'      => 'string'
    ];

    public function handle(RequestInterface $request, Response $response)
    {
        // 参数校验
        $requestData = $request->all();
        $this->validationFactory->make($requestData, $this->rules)->validate();

        $res = $this->logic->find($requestData);
        return $response->success($res);
    }
}