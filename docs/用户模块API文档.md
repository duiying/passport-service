# 用户模块API文档

### 目录

- [创建用户](#创建用户)
- [更新用户](#更新用户)
- [更新用户部分字段](#更新用户部分字段)
- [用户详情](#用户详情)
- [用户列表](#用户列表)

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
