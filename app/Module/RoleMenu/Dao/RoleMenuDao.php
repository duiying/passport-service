<?php

namespace App\Module\RoleMenu\Dao;

use HyperfPlus\MySQL\MySQLDao;

class RoleMenuDao extends MySQLDao
{
    public $connection = 'passport';
    public $table = 't_passport_role_menu';
}