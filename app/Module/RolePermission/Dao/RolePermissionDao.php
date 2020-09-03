<?php

namespace App\Module\RolePermission\Dao;

use HyperfPlus\MySQL\MySQLDao;

class RolePermissionDao extends MySQLDao
{
    public $connection = 'passport';
    public $table = 't_passport_role_permission';
}