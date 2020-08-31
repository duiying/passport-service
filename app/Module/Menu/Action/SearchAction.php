<?php

namespace App\Module\Menu\Action;

use HyperfPlus\Util\Util;
use HyperfPlus\Controller\AbstractController;
use HyperfPlus\Constant\Constant;
use App\Module\Menu\Logic\MenuLogic;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use HyperfPlus\Http\Response;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;

class SearchAction extends AbstractController
{
    /**
     * @Inject()
     * @var MenuLogic
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
        'id'          => 'integer',
        'pid'         => 'integer',
        'name'        => 'string',
        'icon'        => 'string',
        'url'         => 'string',
        'status'      => 'integer'
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