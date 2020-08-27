<?php

declare(strict_types=1);

use HyperfPlus\Route\Route;

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'HyperfPlus\Controller\IndexController@handle');

/**
 * 角色模块
 */
Router::addRoute(['GET'], '/v1/role/search', Route::decoration('Role\Action\SearchAction'));
Router::addRoute(['POST'], '/v1/role/create', Route::decoration('Role\Action\CreateAction'));


/**
 * 管理员模块
 */
Router::addRoute(['GET'], '/v1/user/search', Route::decoration('User\Action\SearchAction'));
Router::addRoute(['POST'], '/v1/user/create', Route::decoration('User\Action\CreateAction'));