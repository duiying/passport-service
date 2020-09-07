<?php

declare(strict_types=1);

use HyperfPlus\Route\Route;

use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'HyperfPlus\Controller\IndexController@handle');

/**
 * 管理员模块
 */
Router::addRoute(['GET'], '/v1/user/search', Route::decoration('User\Action\SearchAction'));
Router::addRoute(['GET'], '/v1/user/find', Route::decoration('User\Action\FindAction'));
Router::addRoute(['POST'], '/v1/user/create', Route::decoration('User\Action\CreateAction'));
Router::addRoute(['POST'], '/v1/user/update', Route::decoration('User\Action\UpdateAction'));
Router::addRoute(['POST'], '/v1/user/update_field', Route::decoration('User\Action\UpdateFieldAction'));
Router::addRoute(['POST'], '/v1/user/login', Route::decoration('User\Action\LoginAction'));

/**
 * 菜单模块
 */
Router::addRoute(['GET'], '/v1/menu/search', Route::decoration('Menu\Action\SearchAction'));
Router::addRoute(['GET'], '/v1/menu/find', Route::decoration('Menu\Action\FindAction'));
Router::addRoute(['POST'], '/v1/menu/create', Route::decoration('Menu\Action\CreateAction'));
Router::addRoute(['POST'], '/v1/menu/update', Route::decoration('Menu\Action\UpdateAction'));
Router::addRoute(['POST'], '/v1/menu/update_field', Route::decoration('Menu\Action\UpdateFieldAction'));

/**
 * 权限模块
 */
Router::addRoute(['GET'], '/v1/permission/search', Route::decoration('Permission\Action\SearchAction'));
Router::addRoute(['GET'], '/v1/permission/find', Route::decoration('Permission\Action\FindAction'));
Router::addRoute(['POST'], '/v1/permission/create', Route::decoration('Permission\Action\CreateAction'));
Router::addRoute(['POST'], '/v1/permission/update', Route::decoration('Permission\Action\UpdateAction'));
Router::addRoute(['POST'], '/v1/permission/update_field', Route::decoration('Permission\Action\UpdateFieldAction'));

/**
 * 角色模块
 */
Router::addRoute(['GET'], '/v1/role/search', Route::decoration('Role\Action\SearchAction'));
Router::addRoute(['GET'], '/v1/role/find', Route::decoration('Role\Action\FindAction'));
Router::addRoute(['POST'], '/v1/role/create', Route::decoration('Role\Action\CreateAction'));
Router::addRoute(['POST'], '/v1/role/update', Route::decoration('Role\Action\UpdateAction'));
Router::addRoute(['POST'], '/v1/role/update_field', Route::decoration('Role\Action\UpdateFieldAction'));