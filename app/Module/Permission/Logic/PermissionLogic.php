<?php

namespace App\Module\Permission\Logic;

use App\Constant\AppErrorCode;
use App\Module\Permission\Constant\PermissionConstant;
use HyperfPlus\Exception\AppException;
use HyperfPlus\Util\Util;
use Hyperf\Di\Annotation\Inject;
use App\Module\Permission\Service\PermissionService;

class PermissionLogic
{
    /**
     * @Inject()
     * @var PermissionService
     */
    private $service;

    /**
     * 检查权限是否存在并返回
     *
     * @param $permissionId
     * @return array
     */
    public function checkPermission($permissionId)
    {
        $permission = $this->service->getLineByWhere(['id' => $permissionId, 'status' => PermissionConstant::PERMISSION_STATUS_NORMAL]);
        if (empty($permission)) throw new AppException(AppErrorCode::PERMISSION_NOT_EXIST_ERROR);
        return $permission;
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
    public function search($requestData, $p, $size)
    {
        $requestData['status'] = PermissionConstant::PERMISSION_STATUS_NORMAL;
        $list  = $this->service->search($requestData, $p, $size);
        $total = $this->service->count($requestData);
        foreach ($list as $k => $v) {
            $list[$k]['url_list'] = !empty($v['url']) ? explode(';', $v['url']) : [];
        }
        return Util::formatSearchRes($p, $size, $total, $list);
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