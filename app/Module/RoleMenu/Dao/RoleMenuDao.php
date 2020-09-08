<?php

namespace App\Module\RoleMenu\Dao;

use App\Module\Menu\Constant\MenuConstant;
use App\Module\Permission\Constant\PermissionConstant;
use App\Module\RoleMenu\Constant\RoleMenuConstant;
use App\Module\RolePermission\Constant\RolePermissionConstant;
use Hyperf\DbConnection\Db;
use HyperfPlus\MySQL\MySQLDao;
use HyperfPlus\Util\Util;

class RoleMenuDao extends MySQLDao
{
    public $connection = 'passport';
    public $table = 't_passport_role_menu';

    public function getRoleMenuByIdList($roleIdList)
    {
        $sql = "select a.role_id,a.menu_id,b.name from t_passport_role_menu a 
left join t_passport_menu b on a.menu_id = b.id
where a.role_id in (" . implode(',', $roleIdList) . ") and a.status = ? and b.status = ? order by b.sort asc";

        $list = Db::connection($this->connection)->select($sql, [
            RoleMenuConstant::ROLE_MENU_STATUS_NORMAL,
            MenuConstant::MENU_STATUS_NORMAL
        ]);

        return Util::objArr2Arr($list);
    }
}