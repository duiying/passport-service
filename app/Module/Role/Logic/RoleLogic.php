<?php

namespace App\Module\Role\Logic;

use App\Constant\AppErrorCode;
use App\Module\Permission\Constant\PermissionConstant;
use App\Module\Permission\Service\PermissionService;
use App\Module\RolePermission\Service\RolePermissionService;
use HyperfPlus\Exception\AppException;
use HyperfPlus\Log\Log;
use HyperfPlus\Util\Util;
use Hyperf\Di\Annotation\Inject;
use App\Module\Role\Service\RoleService;

class RoleLogic
{
    /**
     * @Inject()
     * @var RoleService
     */
    private $service;

    /**
     * @Inject()
     * @var RolePermissionService
     */
    private $rolePermissionService;

    /**
     * @Inject()
     * @var PermissionService
     */
    private $permissionService;

    public function create($requestData)
    {
        $permissionId       = isset($requestData['permission_id']) ? $requestData['permission_id'] : '';
        $permissionIdArr    = Util::ids2IdArr($permissionId);
        if (isset($requestData['permission_id'])) unset($requestData['permission_id']);

        $this->service->beginTransaction();

        try {
            // 创建角色
            $roleId = $this->service->create($requestData);

            // 创建角色权限
            if (!empty($permissionIdArr)) {
                foreach ($permissionIdArr as $k => $v) {
                    // 检查权限是否存在
                    $permission = $this->permissionService->getLineByWhere(['id' => $v, 'status' => PermissionConstant::PERMISSION_STATUS_NORMAL]);
                    if (empty($permission)) throw new AppException(AppErrorCode::PERMISSION_NOT_EXIST_ERROR);

                    // 创建角色权限
                    $this->rolePermissionService->create(['role_id' => $roleId, 'permission_id' => $v]);
                }
            }

            $this->service->commit();
        } catch (\Exception $exception) {
            $this->service->rollBack();
            Log::error('创建角色失败', ['code' => $exception->getCode(), 'msg' => $exception->getMessage(), 'requestData' => $requestData]);
            throw new AppException($exception->getCode(), $exception->getMessage());
        }

        return $roleId;
    }

    /**
     * 更新
     *
     * @param $requestData
     * @return int
     */
    public function update($requestData)
    {
        $id = $requestData['id'];
        unset($requestData['id']);
        return $this->service->update(['id' => $id], $requestData);
    }

    /**
     * 更新字段
     *
     * @param $requestData
     * @return int
     */
    public function updateField($requestData)
    {
        $id = $requestData['id'];
        unset($requestData['id']);
        return $this->service->update(['id' => $id], $requestData);
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
         $list  = $this->service->search($requestData, $p, $size);
         $total = $this->service->count($requestData);
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