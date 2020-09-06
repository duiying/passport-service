<?php

namespace App\Module\Role\Logic;

use App\Constant\AppErrorCode;
use App\Module\Permission\Constant\PermissionConstant;
use App\Module\Permission\Logic\PermissionLogic;
use App\Module\Permission\Service\PermissionService;
use App\Module\Role\Constant\RoleConstant;
use App\Module\RolePermission\Constant\RolePermissionConstant;
use App\Module\RolePermission\Service\RolePermissionService;
use HyperfPlus\Exception\AppException;
use HyperfPlus\Log\Log;
use HyperfPlus\Log\StdoutLog;
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

    /**
     * @Inject()
     * @var PermissionLogic
     */
    private $permissionLogic;

    /**
     * 检查角色名称是否重复
     *
     * @param $name
     * @param int $id
     */
    public function checkNameRepeat($name, $id = 0)
    {
        $role = $this->service->getLineByWhere(['name' => $name, 'status' => RoleConstant::ROLE_STATUS_NORMAL]);
        if (empty($role)) return;
        if ($role['id'] != $id) throw new AppException(AppErrorCode::ROLE_NAME_REPEAT_ERROR);
    }

    /**
     * 检查角色是否存在并返回
     *
     * @param $id
     * @return array
     */
    public function checkRole($id)
    {
        $role = $this->service->getLineByWhere(['id' => $id, 'status' => RoleConstant::ROLE_STATUS_NORMAL]);
        if (empty($role)) throw new AppException(AppErrorCode::ROLE_NOT_EXIST_ERROR);
        return $role;
    }

    /**
     * 超级管理员角色不允许更新
     *
     * @param $admin
     */
    public function checkAdmin($admin)
    {
        if ($admin == RoleConstant::ADMIN_YES) throw new AppException(AppErrorCode::ROLE_ADMIN_UPDATE_ERROR);
    }

    public function create($requestData)
    {
        $permissionId       = isset($requestData['permission_id']) ? $requestData['permission_id'] : '';
        $permissionIdArr    = Util::ids2IdArr($permissionId);
        if (isset($requestData['permission_id'])) unset($requestData['permission_id']);

        // 检查角色名称是否重复
        $this->checkNameRepeat($requestData['name']);

        $this->service->beginTransaction();

        try {
            // 创建角色
            $roleId = $this->service->create($requestData);

            // 创建角色权限
            if (!empty($permissionIdArr)) {
                foreach ($permissionIdArr as $k => $v) {
                    // 检查权限是否已删除
                    $this->permissionLogic->checkPermission($v);

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

        // 检查角色是否存在
        $role = $this->checkRole($id);
        // 超级管理员角色不允许更新
        $this->checkAdmin($role['admin']);
        // 检查角色名称是否重复
        $this->checkNameRepeat($requestData['name'], $id);

        $permissionId       = isset($requestData['permission_id']) ? $requestData['permission_id'] : '';
        $permissionIdArr    = Util::ids2IdArr($permissionId);
        if (isset($requestData['permission_id'])) unset($requestData['permission_id']);

        $this->service->beginTransaction();

        try {
            // 更新角色
            $this->service->update(['id' => $id], $requestData);

            // 将角色的所有权限置为已删除
            $this->rolePermissionService->update(['role_id' => $id], ['status' => RolePermissionConstant::ROLE_PERMISSION_STATUS_DELETE]);

            if (!empty($permissionIdArr)) {
                foreach ($permissionIdArr as $k => $v) {
                    // 检查权限是否已删除
                    $permission = $this->permissionService->getLineByWhere(['id' => $v, 'status' => PermissionConstant::PERMISSION_STATUS_NORMAL]);
                    if (empty($permission)) throw new AppException(AppErrorCode::PERMISSION_NOT_EXIST_ERROR);

                    if ($this->rolePermissionService->search(['role_id' => $id, 'permission_id' => $v])) {
                        // 恢复角色权限
                        $this->rolePermissionService->update(['role_id' => $id, 'permission_id' => $v], ['status' => RolePermissionConstant::ROLE_PERMISSION_STATUS_NORMAL]);
                    } else {
                        // 创建角色权限
                        $this->rolePermissionService->create(['role_id' => $id, 'permission_id' => $v]);
                    }
                }
            }

            $this->service->commit();
        } catch (\Exception $exception) {
            $this->service->rollBack();
            Log::error('更新角色失败', ['code' => $exception->getCode(), 'msg' => $exception->getMessage(), 'requestData' => $requestData]);
            throw new AppException($exception->getCode(), $exception->getMessage());
        }

        return true;
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

        // 检查角色是否存在
        $role = $this->checkRole($id);
        // 超级管理员角色不允许更新
        $this->checkAdmin($role['admin']);
        // 检查角色名称是否重复
        if (isset($requestData['name'])) $this->checkNameRepeat($requestData['name'], $id);

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
        $requestData['status'] = RoleConstant::ROLE_STATUS_NORMAL;
        $list  = $this->service->search($requestData, $p, $size, ['*'], ['admin' => 'desc', 'sort' => 'asc']);
        $total = $this->service->count($requestData);

        $roleIdList = empty($list) ? [] : array_column($list, 'id');

         // 角色对应的权限
         $permissionListGroupByRoleId = [];
         if (!empty($roleIdList)) {
             $permissionList = $this->rolePermissionService->getRolePermissionByIdList($roleIdList);
             if (!empty($permissionList)) {
                 foreach ($permissionList as $k => $v) {
                     $permissionListGroupByRoleId[$v['role_id']][] = $v;
                 }
             }
         }

         foreach ($list as $k => $v) {
             $list[$k]['permission_list'] = isset($permissionListGroupByRoleId[$v['id']]) ? $permissionListGroupByRoleId[$v['id']] : [];
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
        $id     = $requestData['id'];
        $role   = $this->checkRole($id);

        // 查找角色对应的权限
        $role['permission_list'] = $this->rolePermissionService->getRolePermissionByIdList([$id]);

        return $role;
    }
}