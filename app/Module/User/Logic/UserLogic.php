<?php

namespace App\Module\User\Logic;

use App\Constant\AppErrorCode;
use App\Module\Role\Logic\RoleLogic;
use App\Module\User\Constant\UserConstant;
use App\Module\UserRole\Constant\UserRoleConstant;
use App\Module\UserRole\Service\UserRoleService;
use HyperfPlus\Exception\AppException;
use HyperfPlus\Log\Log;
use HyperfPlus\Util\Util;
use Hyperf\Di\Annotation\Inject;
use App\Module\User\Service\UserService;

class UserLogic
{
    /**
     * @Inject()
     * @var UserService
     */
    private $service;

    /**
     * @Inject()
     * @var UserRoleService
     */
    private $userRoleService;

    /**
     * @Inject()
     * @var RoleLogic
     */
    private $roleLogic;

    /**
     * 检查角色是否存在并返回
     *
     * @param $id
     * @return array
     */
    public function checkUser($id)
    {
        $user = $this->service->getLineByWhere(['id' => $id, 'status' => UserConstant::USER_STATUS_NORMAL]);
        if (empty($user)) throw new AppException(AppErrorCode::USER_NOT_EXIST_ERROR);
        return $user;
    }

    /**
     * 创建
     *
     * @param $requestData
     * @return int
     */
    public function create($requestData)
    {
        $roleId         = isset($requestData['role_id']) ? $requestData['role_id'] : '';
        $roleIdArr      = Util::ids2IdArr($roleId);
        if (isset($requestData['role_id'])) unset($requestData['role_id']);

        $this->service->beginTransaction();

        try {
            // 创建用户
            $userId = $this->service->create($requestData);

            // 创建用户角色
            if (!empty($roleIdArr)) {
                foreach ($roleIdArr as $k => $v) {
                    // 检查角色
                    $this->roleLogic->checkRole($v);

                    // 创建角色权限
                    $this->userRoleService->create(['user_id' => $userId, 'role_id' => $v]);
                }
            }

            $this->service->commit();
        } catch (\Exception $exception) {
            $this->service->rollBack();
            Log::error('创建管理员失败', ['code' => $exception->getCode(), 'msg' => $exception->getMessage(), 'requestData' => $requestData]);
            throw new AppException($exception->getCode(), $exception->getMessage());
        }

        return $userId;
    }

    /**
     * 更新
     *
     * @param $requestData
     * @return int
     */
    public function update($requestData)
    {
        $id     = $requestData['id'];
        unset($requestData['id']);

        // 检查用户是否存在
        $user = $this->checkUser($id);
        // ROOT 用户不允许更新角色
        if ($user['root'] == UserConstant::IS_ROOT && isset($requestData['role_id'])) {
            unset($requestData['role_id']);
        }

        $roleId         = isset($requestData['role_id']) ? $requestData['role_id'] : '';
        $roleIdArr      = Util::ids2IdArr($roleId);
        if (isset($requestData['role_id'])) unset($requestData['role_id']);

        $this->service->beginTransaction();

        try {
            // 更新管理员
            $this->service->update(['id' => $id], $requestData);

            if (!empty($roleIdArr)) {
                // 将管理员的所有角色置为已删除
                $this->userRoleService->update(['user_id' => $id], ['status' => UserRoleConstant::USER_ROLE_STATUS_DELETE]);

                foreach ($roleIdArr as $k => $v) {
                    // 检查角色是否已删除
                    $this->roleLogic->checkRole($v);

                    if ($this->userRoleService->search(['user_id' => $id, 'role_id' => $v])) {
                        // 恢复角色权限
                        $this->userRoleService->update(['user_id' => $id, 'role_id' => $v], ['status' => UserRoleConstant::USER_ROLE_STATUS_NORMAL]);
                    } else {
                        // 创建角色权限
                        $this->userRoleService->create(['user_id' => $id, 'role_id' => $v]);
                    }
                }
            }

            $this->service->commit();
        } catch (\Exception $exception) {
            $this->service->rollBack();
            Log::error('更新管理员失败', ['code' => $exception->getCode(), 'msg' => $exception->getMessage(), 'requestData' => $requestData]);
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
        $id     = $requestData['id'];
        unset($requestData['id']);

        // 检查用户是否存在
        $user = $this->checkUser($id);
        // ROOT 用户不允许删除
        if ($user['root'] == UserConstant::IS_ROOT && isset($requestData['status']) && $requestData['status'] == UserConstant::USER_STATUS_DELETE) {
            throw new AppException(AppErrorCode::ROOT_USER_DELETE_ERROR);
        }

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
        $requestData['status'] = UserConstant::USER_STATUS_NORMAL;
        $list  = $this->service->search($requestData, $p, $size,
            ['id', 'name', 'email', 'mobile', 'position', 'mtime', 'ctime', 'sort', 'root'],
            ['root' => 'desc', 'sort' => 'asc', 'ctime' => 'desc']
        );

        $userRoleGroupByUserId = [];
        if (!empty($list)) {
            $userIdList = array_column($list, 'id');
            $userRoleList = $this->userRoleService->getUserRoleList($userIdList);

            if (!empty($userRoleList)) {
                foreach ($userRoleList as $k => $v) {
                    $userRoleGroupByUserId[$v['user_id']][] = $v;
                }
            }

            foreach ($list as $k => $v) {
                $list[$k]['role_list'] = isset($userRoleGroupByUserId[$v['id']]) ? $userRoleGroupByUserId[$v['id']] : [];
            }
        }

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
        $id = $requestData['id'];
        $user = $this->checkUser($id);
        $user['role_list'] = $this->userRoleService->getUserRoleList([$id]);
        return $user;
    }
}