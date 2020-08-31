<?php

namespace App\Module\Menu\Dao;

use HyperfPlus\MySQL\MySQLDao;

class MenuDao extends MySQLDao
{
    public $connection = 'passport';
    public $table = 't_passport_menu';
}