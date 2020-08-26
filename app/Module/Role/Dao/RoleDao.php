<?php

namespace App\Module\Role\Dao;

use HyperfPlus\MySQL\MySQLDao;

class RoleDao extends MySQLDao
{
    public $connection = 'passport';
    public $table = 't_passport_role';
}