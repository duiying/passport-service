<?php

namespace App\Module\Menu\Logic;

use App\Constant\AppErrorCode;
use App\Module\Menu\Constant\MenuConstant;
use HyperfPlus\Exception\AppException;
use HyperfPlus\Log\StdoutLog;
use HyperfPlus\Util\Util;
use Hyperf\Di\Annotation\Inject;
use App\Module\Menu\Service\MenuService;

class MenuLogic
{
    /**
     * @Inject()
     * @var MenuService
     */
    private $service;

    /**
     * 检查菜单是否存在并返回
     *
     * @param $menuId
     * @return array
     */
    public function checkMenu($menuId)
    {
        // 只允许添加二级菜单
        $menu = $this->service->getLineByWhere(['id' => $menuId, 'status' => MenuConstant::MENU_STATUS_NORMAL, 'pid' => ['>', 0]]);
        if (empty($menu)) throw new AppException(AppErrorCode::MENU_NOT_EXIST_ERROR);
        return $menu;
    }

    /**
     * 创建
     *
     * @param $requestData
     * @return int
     */
    public function create($requestData)
    {
        $data = $requestData;
        return $this->service->create($data);
    }

    /**
     * 更新
     *
     * @param $requestData
     * @return int
     */
    public function update($requestData)
    {
        $data   = $requestData;
        $id     = $requestData['id'];
        unset($data['id']);
        return $this->service->update(['id' => $id], $data);
    }

    /**
     * 更新字段
     *
     * @param $requestData
     * @return int
     */
    public function updateField($requestData)
    {
        $data   = $requestData;
        $id     = $requestData['id'];
        unset($data['id']);
        return $this->service->update(['id' => $id], $data);
    }

    /**
     * 查找
     *
     * @param $requestData
     * @param $p
     * @param $size
     * @return array
     */
    public function search($requestData)
    {
        // 一级菜单列表
        if (isset($requestData['pid'])) {
            $classAMenuList = $this->service->search(['pid' => 0, 'status' => MenuConstant::MENU_STATUS_NORMAL]);
            return ['list' => $classAMenuList];
        }

        // 一级菜单列表
        $classAMenuList     = $this->service->search(['pid' => 0]);
        // 二级菜单列表
        $classBMenuList     = $this->service->search(['pid' => ['>', 0]]);

        if (empty($classAMenuList)) return [];

        foreach ($classAMenuList as $classAMenuKey => $classAMenuVal) {
            $classAMenuList[$classAMenuKey]['sub_menu_list'] = [];

            foreach ($classBMenuList as $classBMenuKey => $classBMenuVal) {
                if ($classBMenuVal['pid'] == $classAMenuVal['id']) {
                    $classAMenuList[$classAMenuKey]['sub_menu_list'][] = $classBMenuVal;
                }
            }
        }

        return ['list' => $classAMenuList];
    }

    /**
     * 获取一行
     *
     * @param $requestData
     * @return array
     */
    public function find($requestData)
    {
        return $this->service->getLineByWhere($requestData);
    }
}