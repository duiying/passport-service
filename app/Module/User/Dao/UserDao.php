<?php

namespace App\Module\User\Dao;

use HyperfPlus\MySQL\MySQLDao;

class UserDao extends MySQLDao
{
    public $connection = 'passport';
    public $table = 't_passport_user';
}