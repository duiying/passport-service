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
Router::addRoute(['GET'], '/v1/user/find', Route::decoration('User\Action\FindAction'));
Router::addRoute(['POST'], '/v1/user/create', Route::decoration('User\Action\CreateAction'));
Router::addRoute(['POST'], '/v1/user/update', Route::decoration('User\Action\UpdateAction'));
Router::addRoute(['POST'], '/v1/user/update_field', Route::decoration('User\Action\UpdateFieldAction'));

/**
 * 菜单模块
 */
Router::addRoute(['GET'], '/v1/menu/search', Route::decoration('Menu\Action\SearchAction'));
Router::addRoute(['GET'], '/v1/menu/find', Route::decoration('Menu\Action\FindAction'));
Router::addRoute(['POST'], '/v1/menu/create', Route::decoration('Menu\Action\CreateAction'));
Router::addRoute(['POST'], '/v1/menu/update', Route::decoration('Menu\Action\UpdateAction'));
Router::addRoute(['POST'], '/v1/menu/update_field', Route::decoration('Menu\Action\UpdateFieldAction'));