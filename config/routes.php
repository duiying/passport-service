<?php

declare(strict_types=1);

use HyperfPlus\Route\Route;
use Hyperf\HttpServer\Router\Router;
use Hyperf\Tracer\Middleware\TraceMiddleware;
use HyperfPlus\Middleware\CorsMiddleware;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'HyperfPlus\Controller\IndexController@handle');

Router::get('/favicon.ico', function () {
    return '';
});

Router::addGroup('/v1/',function () {
    /**
     * 用户模块
     */
    Router::addRoute(['GET'], 'user/search', Route::decoration('User\Action\SearchAction'));
    Router::addRoute(['GET'], 'user/find', Route::decoration('User\Action\FindAction'));
    Router::addRoute(['POST'], 'user/create', Route::decoration('User\Action\CreateAction'));
    Router::addRoute(['POST'], 'user/update', Route::decoration('User\Action\UpdateAction'));
    Router::addRoute(['POST'], 'user/update_field', Route::decoration('User\Action\UpdateFieldAction'));
    Router::addRoute(['POST'], 'user/login', Route::decoration('User\Action\LoginAction'));
    Router::addRoute(['POST'], 'user/logout', Route::decoration('User\Action\LogoutAction'));
    Router::addRoute(['GET'], 'user/menu', Route::decoration('User\Action\MenuAction'));
    Router::addRoute(['GET'], 'user/check_permission', Route::decoration('User\Action\CheckPermissionAction'));

    /**
     * 菜单模块
     */
    Router::addRoute(['GET'], 'menu/search', Route::decoration('Menu\Action\SearchAction'));
    Router::addRoute(['GET'], 'menu/find', Route::decoration('Menu\Action\FindAction'));
    Router::addRoute(['POST'], 'menu/create', Route::decoration('Menu\Action\CreateAction'));
    Router::addRoute(['POST'], 'menu/update', Route::decoration('Menu\Action\UpdateAction'));
    Router::addRoute(['POST'], 'menu/update_field', Route::decoration('Menu\Action\UpdateFieldAction'));

    /**
     * 权限模块
     */
    Router::addRoute(['GET'], 'permission/search', Route::decoration('Permission\Action\SearchAction'));
    Router::addRoute(['GET'], 'permission/find', Route::decoration('Permission\Action\FindAction'));
    Router::addRoute(['POST'], 'permission/create', Route::decoration('Permission\Action\CreateAction'));
    Router::addRoute(['POST'], 'permission/update', Route::decoration('Permission\Action\UpdateAction'));
    Router::addRoute(['POST'], 'permission/update_field', Route::decoration('Permission\Action\UpdateFieldAction'));

    /**
     * 角色模块
     */
    Router::addRoute(['GET'], 'role/search', Route::decoration('Role\Action\SearchAction'));
    Router::addRoute(['GET'], 'role/find', Route::decoration('Role\Action\FindAction'));
    Router::addRoute(['POST'], 'role/create', Route::decoration('Role\Action\CreateAction'));
    Router::addRoute(['POST'], 'role/update', Route::decoration('Role\Action\UpdateAction'));
    Router::addRoute(['POST'], 'role/update_field', Route::decoration('Role\Action\UpdateFieldAction'));
}, ['middleware' => [TraceMiddleware::class, CorsMiddleware::class]]);