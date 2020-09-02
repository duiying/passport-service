<?php

namespace App\Module\Permission\Dao;

use HyperfPlus\MySQL\MySQLDao;

class PermissionDao extends MySQLDao
{
    public $connection = 'passport';
    public $table = 't_passport_permission';
}