# 用户模块API文档

### 目录

- [创建用户](#创建用户)
- [更新用户](#更新用户)
- [更新用户部分字段](#更新用户部分字段)
- [用户详情](#用户详情)
- [用户列表](#用户列表)
- [用户拥有的菜单](#用户拥有的菜单)
- [登录](#登录)
- [退出登录](#退出登录)

### 创建用户

**请求 URL**  

http://passport.micro.service.com/v1/user/create

**请求方式**  

POST  

**请求参数**  

| 字段 | 必填 | 类型 | 描述 |  
| :--- | :---- | :---- | :---- |
| name | 是 | string | 姓名 |
| email | 是 | string | 邮箱 |
| mobile | 是 | string | 手机号 |
| position | 是 | string | 职位 |
| password | 是 | string | 密码 |
| role_id | 否 | string | 角色 ID，多个 ID 之间用英文逗号隔开 |

**返回值**  

```json
{
  "code": 0,
  "msg": "",
  "data": 2
}
```  

**备注**  
- 需要校验邮箱格式
- 需要校验 role_id 是否有效
- 邮箱作为登录的唯一标识，需要校验是否重复
- 密码需要加密
- 创建用户和创建用户角色需要在事务中执行，保证原子性

### 更新用户

**请求 URL**  

http://passport.micro.service.com/v1/user/update

**请求方式**  

POST  

**请求参数**  

| 字段 | 必填 | 类型 | 描述 |  
| :--- | :---- | :---- | :---- |
| id | 是 | int | ID |
| name | 是 | string | 姓名 |
| email | 是 | string | 邮箱 |
| mobile | 是 | string | 手机号 |
| position | 是 | string | 职位 |
| password | 否 | string | 密码 |
| role_id | 否 | string | 角色 ID，多个 ID 之间用英文逗号隔开 |

**返回值**  

```json
{
  "code": 0,
  "msg": "",
  "data": true
}
```  

**备注**  
- 需要校验邮箱格式
- 需要检查用户是否存在
- 邮箱作为登录的唯一标识，需要校验是否重复
- ROOT 用户不允许更新角色
- 密码需要加密
- 检查角色是否存在
- 在事务中执行更新管理员和更新管理员角色，保证原子性

### 更新用户部分字段

**请求 URL**  

http://passport.micro.service.com/v1/user/update_field

**请求方式**  

POST  

**请求参数**  

| 字段 | 必填 | 类型 | 描述 |  
| :--- | :---- | :---- | :---- |
| id | 是 | int | ID |
| status | 否 | int | 状态 {-1：删除；1：正常；}|

**返回值**  

```json
{
  "code": 0,
  "msg": "",
  "data": 1
}
```  

**备注**  
- 检查 status 字段是否有效
- ROOT 用户不允许删除
- 该接口目前只有删除、恢复用户功能在用

### 用户详情

**请求 URL**  

http://passport.micro.service.com/v1/user/find

**请求方式**  

GET  

**请求参数**  

| 字段 | 必填 | 类型 | 描述 |  
| :--- | :---- | :---- | :---- |
| id | 是 | int | ID |

**返回值**  

```json
{
  "code": 0,                      
  "msg": "",
  "data": {
    "id": 1, // ID
    "name": "admin", // 姓名
    "email": "admin@gmail.com", // 邮箱
    "mobile": "18311413962", // 手机号
    "position": "技术负责人", // 职位
    "status": 1, // 状态 {-1：删除；1：正常；}
    "root": 1, // 超级管理员 {0：否；1：是；}
    "sort": 1, // 排序（正序）
    "mtime": "2020-09-06 12:54:51",
    "ctime": "2020-08-27 17:08:08",
    "role_list": [ // 拥有的角色列表
      {
        "user_id": 1, // 管理员 ID
        "role_id": 1, // 角色 ID
        "name": "超级管理员", // 角色名称
        "admin": 1 // 角色是否是 超级管理员 {0：否；1：是；}
      }
    ]
  }
}
```  

**备注**
- 需要检查用户是否存在
- 查询出用户所拥有的角色列表（用户角色表和角色表连表，需要 1、用户角色表记录状态正常；2、角色表记录状态正常；）

### 用户列表

**请求 URL**  

http://passport.micro.service.com/v1/user/search

**请求方式**  

GET  

**请求参数**  

| 字段 | 必填 | 类型 | 描述 |  
| :--- | :---- | :---- | :---- |
| id | 否 | int | ID |
| p | 否 | int | 页码，默认为 1 |
| size | 否 | int | 每页条数，默认为 20 |
| name | 否 | string | 姓名 |
| email | 否 | string | 邮箱 |
| mobile | 否 | string | 手机号 |
| position | 否 | string | 职位 |
| mobile | 否 | string | 手机号 |

**返回值**  

```json
{
  "code": 0,
  "msg": "",
  "data": {
    "p": 1, // 页码
    "size": 20, // 每页条数
    "total": 2, // 总条数
    "next": 0, // 是否有下一页 {0：没有；1：有；}
    "list": [ // 用户列表
      {
        "id": 1, // 用户 ID
        "name": "admin", // 姓名
        "email": "admin@gmail.com", // 邮箱
        "mobile": "18311413962", // 手机号
        "position": "技术负责人", // 职位
        "mtime": "2020-09-06 12:54:51",
        "ctime": "2020-08-27 17:08:08",
        "sort": 1, // 排序
        "root": 1, // 超级管理员 {0：否；1：是；}
        "role_list": [ // 拥有的角色列表
          {
            "user_id": 1, // 管理员 ID
            "role_id": 1, // 角色 ID
            "name": "超级管理员", // 角色名称
            "admin": 1 // 角色是否是 超级管理员 {0：否；1：是；}
          }
        ]
      },
      {
        "id": 5,
        "name": "test",
        "email": "test@qq.com",
        "mobile": "18888888888",
        "position": "测试工程师",
        "mtime": "2020-11-28 12:26:36",
        "ctime": "2020-11-28 08:14:38",
        "sort": 99,
        "root": 0,
        "role_list": []
      }
    ]
  }
}
```  

**备注**
- 只查询正常状态的用户
- 查询出用户所拥有的角色列表（用户角色表和角色表连表，需要 1、用户角色表记录状态正常；2、角色表记录状态正常；）

### 用户拥有的菜单

**请求 URL**  

http://passport.micro.service.com/v1/user/menu

**请求方式**  

GET  

**请求参数**  

| 字段 | 必填 | 类型 | 描述 |  
| :--- | :---- | :---- | :---- |
| user_id | 否 | int | 用户 ID |

**返回值**  

```json
{
  "code": 0,
  "msg": "",
  "data": {
    "list": [ // 菜单列表
      {
        "id": 1, // 菜单 ID
        "pid": 0, // 父级ID {0：顶级菜单；}
        "name": "权限管理", // 菜单名称
        "icon": "fa fa-tasks", // icon
        "url": "", // 路由
        "status": 1, // 状态 {-1：删除；1：正常；}
        "sort": 99, // 排序
        "mtime": "2020-08-31 21:12:15",
        "ctime": "2020-08-31 21:11:51",
        "sub_menu_list": [ // 二级菜单
          {
            "id": 2,
            "pid": 1,
            "name": "管理员",
            "icon": "fa fa-users",
            "url": "\/view\/user\/search",
            "status": 1,
            "sort": 99,
            "mtime": "2020-09-08 10:20:42",
            "ctime": "2020-08-31 21:21:10"
          },
          {
            "id": 3,
            "pid": 1,
            "name": "角色",
            "icon": "fa fa-user",
            "url": "\/view\/role\/search",
            "status": 1,
            "sort": 99,
            "mtime": "2020-08-31 21:28:26",
            "ctime": "2020-08-31 21:21:53"
          },
          {
            "id": 4,
            "pid": 1,
            "name": "权限",
            "icon": "fa fa-ban",
            "url": "\/view\/permission\/search",
            "status": 1,
            "sort": 99,
            "mtime": "2020-09-02 12:28:02",
            "ctime": "2020-08-31 21:23:09"
          },
          {
            "id": 5,
            "pid": 1,
            "name": "菜单",
            "icon": "fa fa-bars",
            "url": "\/view\/menu\/search",
            "status": 1,
            "sort": 99,
            "mtime": "2020-09-01 12:09:49",
            "ctime": "2020-09-01 12:09:49"
          }
        ]
      }
    ]
  }
}
```  

**备注**
- 检查用户是否存在
- 查出用户所拥有的角色，再查出用户所拥有的菜单
- 如果用户拥有超级管理员角色，返回所有菜单

### 登录

**请求 URL**  

http://passport.micro.service.com/v1/user/login

**请求方式**  

POST  

**请求参数**  

| 字段 | 必填 | 类型 | 描述 |  
| :--- | :---- | :---- | :---- |
| email | 是 | string | 邮箱 |
| password | 是 | string | 密码 |

**返回值**  

```json
{
  "code": 0,
  "msg": "",
  "data": {
    "access_token": "5c7f9916859ab439eb05e105c54591e9", // 令牌
    "expire": 7200 // 过期，单位为秒
  }
}
```  

**备注**  
- 先检查用户是否存在
- 如果用户存在，再比对密码是否正确
- 密码校验通过，生成 token
- 清除之前的 token 缓存（如果有的话），保证管理员同时只有一个有效 token
- 缓存双写 （1）可以通过 token 找到管理员信息（2）可以通过管理员 ID 获取 token 信息

### 退出登录

**请求 URL**  

http://passport.micro.service.com/v1/user/logout

**请求方式**  

POST  

**请求参数**  

| 字段 | 必填 | 类型 | 描述 |  
| :--- | :---- | :---- | :---- |
| access_token | 是 | string | 登录令牌 |

**返回值**  

```json
{
  "code": 0,
  "msg": "",
  "data": true
}
```  

**备注**  
- 清除缓存

### 检查用户权限

**请求 URL**  

http://passport.micro.service.com/v1/user/check_permission

**请求方式**  

GET  

**请求参数**  

| 字段 | 必填 | 类型 | 描述 |  
| :--- | :---- | :---- | :---- |
| access_token | 是 | string | 登录令牌 |
| url | 是 | string | 路由 |

**返回值**  

```json
{
  "code": 0,
  "msg": "",
  "data": 1
}
```  

**备注**  
- 根据 access_token 获取用户 ID，如果从缓存中没有获取到用户 ID，抛出异常
- 部分路由直接返回，不需要校验权限
- 如果用户有超级管理员角色，直接返回
- 查找角色对应的权限
- 权限路由去重
- 请求的路由不在该用户拥有的权限列表中，则表示该用户无该路由的权限
