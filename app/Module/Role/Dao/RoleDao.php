<?php

namespace App\Module\Role\Dao;

use App\Module\Permission\Constant\PermissionConstant;
use App\Module\RolePermission\Constant\RolePermissionConstant;
use Hyperf\DbConnection\Db;
use HyperfPlus\Log\StdoutLog;
use HyperfPlus\MySQL\MySQLDao;
use HyperfPlus\Util\Util;

class RoleDao extends MySQLDao
{
    public $connection = 'passport';
    public $table = 't_passport_role';

    /**
     * 查找角色对应权限
     *
     * @param array $roleIdList
     * @return array
     */
    public function getRolePermissionById($roleIdList = [])
    {
        $sql = 'select a.permission_id,b.name,b.url from t_passport_role_permission a 
left join t_passport_permission b on a.permission_id = b.id
where a.role_id in (?) and a.status = ? and b.status = ? order by b.sort asc';

        $list = Db::connection($this->connection)->select($sql, [
            implode(',', $roleIdList),
            RolePermissionConstant::ROLE_PERMISSION_STATUS_NORMAL,
            PermissionConstant::PERMISSION_STATUS_NORMAL
        ]);

        return Util::objArr2Arr($list);
    }
}