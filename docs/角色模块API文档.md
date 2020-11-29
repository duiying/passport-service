# 角色模块API文档

### 目录

- [创建角色](#创建角色)
- [更新角色](#更新角色)
- [更新角色部分字段](#更新角色部分字段)
- [角色详情](#角色详情)
- [角色列表](#角色列表)

### 创建角色

**请求 URL**  

http://passport.micro.service.com/v1/role/create

**请求方式**  

POST  

**请求参数**  

| 字段 | 必填 | 类型 | 描述 |  
| :--- | :---- | :---- | :---- |
| name | 是 | string | 角色名称 |
| sort | 否 | int | 排序（正序） |
| permission_id | 否 | string | 权限 ID 集合，多个之间用英文逗号隔开 |
| menu_id | 否 | string | 菜单 ID 集合，多个之间用英文逗号隔开 |

**返回值**  

```json
{
  "code": 0,
  "msg": "",
  "data": 6
}
```  

**备注**  

- 创建角色、创建角色权限、创建角色菜单需要在事务中执行，保证原子性
- 检查权限是否已删除
- 检查菜单是否已删除
- 检查角色名称是否重复

### 更新角色

**请求 URL**  

http://passport.micro.service.com/v1/role/update

**请求方式**  

POST  

**请求参数**  

| 字段 | 必填 | 类型 | 描述 |  
| :--- | :---- | :---- | :---- |
| id | 是 | int | ID |
| name | 是 | string | 角色名称 |
| sort | 否 | int | 排序（正序） |
| permission_id | 否 | string | 权限 ID 集合，多个之间用英文逗号隔开 |
| menu_id | 否 | string | 菜单 ID 集合，多个之间用英文逗号隔开 |

**返回值**  

```json
{
  "code": 0,
  "msg": "",
  "data": true
}
```  

**备注**  

- 检查角色是否存在
- 超级管理员角色不允许更新
- 检查角色名称是否重复
- 事务中执行，保证操作的原子性

### 更新角色部分字段

**请求 URL**  

http://passport.micro.service.com/v1/role/update_field

**请求方式**  

POST  

**请求参数**  

| 字段 | 必填 | 类型 | 描述 |  
| :--- | :---- | :---- | :---- |
| id | 是 | int | ID |
| status | 否 | int | 状态 {-1：删除；1：正常；} |

**返回值**  

```json
{
  "code": 0,
  "msg": "",
  "data": 1
}
```  

**备注**  

- 检查角色是否存在
- 超级管理员角色不允许更新
- 检查角色名称是否重复
- 检查 status 字段

### 角色详情

**请求 URL**  

http://passport.micro.service.com/v1/role/find

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
    "id": 1,
    "name": "超级管理员",
    "admin": 1,
    "status": 1,
    "sort": 1,
    "mtime": "2020-09-04 14:26:32",
    "ctime": "2020-09-02 19:45:21",
    "permission_list": [], // 角色对应的权限
    "menu_list": [] // 角色对应的菜单
  }
}
```  

**备注**  

### 角色列表

**请求 URL**  

http://passport.micro.service.com/v1/role/search

**请求方式**  

GET  

**请求参数**  

| 字段 | 必填 | 类型 | 描述 |  
| :--- | :---- | :---- | :---- |
| p | 否 | int | 页码，默认为 1 |
| size | 否 | int | 每页条数，默认为 20 |
| id | 否 | int | ID |
| name | 否 | string | 角色名称 |
| admin | 否 | int | 超级管理员 {0：否；1：是；} |

**返回值**  

```json
{
  "code": 0,
  "msg": "",
  "data": {
    "p": 1,
    "size": 20,
    "total": 1,
    "next": 0,
    "list": [
      {
        "id": 1,
        "name": "超级管理员",
        "admin": 1,
        "status": 1,
        "sort": 1,
        "mtime": "2020-09-04 14:26:32",
        "ctime": "2020-09-02 19:45:21",
        "permission_list": [],
        "menu_list": []
      }
    ]
  }
}
```  

**备注**  
