<?php

namespace App\Module\User\Action;

use HyperfPlus\Util\Util;
use HyperfPlus\Controller\AbstractController;
use App\Module\User\Logic\UserLogic;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use HyperfPlus\Http\Response;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;

class UpdateAction extends AbstractController
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
        'id'            => 'required|integer',
        'name'          => 'required|string|max:50',
        'email'         => 'required|email|max:50',
        'mobile'        => 'required|string|max:20',
        'position'      => 'required|string|max:50',
        'password'      => 'string|min:6|max:32',
        'role_id'       => 'string',
    ];

    public function handle(RequestInterface $request, Response $response)
    {
        // 参数校验
        $requestData = $request->all();
        $this->validationFactory->make($requestData, $this->rules)->validate();
        $requestData = Util::sanitize($requestData, $this->rules);

        $requestData['mtime'] = date('Y-m-d H:i:s');
        if (isset($requestData['password']) && empty($requestData['password'])) unset($requestData['password']);

        $res = $this->logic->update($requestData);
        return $response->success($res);
    }
}