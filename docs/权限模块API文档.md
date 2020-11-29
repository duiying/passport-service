# 权限模块API文档

### 目录

- [创建权限](#创建权限)
- [更新权限](#更新权限)
- [更新权限部分字段](#更新权限部分字段)
- [权限详情](#权限详情)
- [权限列表](#权限列表)

### 创建权限

**请求 URL**  

http://passport.micro.service.com/v1/permission/create

**请求方式**  

POST  

**请求参数**  

| 字段 | 必填 | 类型 | 描述 |  
| :--- | :---- | :---- | :---- |
| name | 是 | string | 权限名称 |
| url | 是 | string | 路由（多个之间用英文分号隔开） |
| sort | 否 | int | 排序（正序） |

**返回值**  

```json
{
  "code": 0,
  "msg": "",
  "data": 6
}
```  

**备注**  

### 更新权限

**请求 URL**  

http://passport.micro.service.com/v1/permission/update

**请求方式**  

POST  

**请求参数**  

| 字段 | 必填 | 类型 | 描述 |  
| :--- | :---- | :---- | :---- |
| id | 是 | int | ID |
| name | 是 | string | 权限名称 |
| url | 是 | string | 路由（多个之间用英文分号隔开） |
| sort | 否 | int | 排序（正序） |

**返回值**  

```json
{
  "code": 0,
  "msg": "",
  "data": 1
}
```  

**备注**  

### 更新权限部分字段

**请求 URL**  

http://passport.micro.service.com/v1/permission/update_field

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
- 需要检查 status 字段是否有效  

### 权限详情

**请求 URL**  

http://passport.micro.service.com/v1/permission/find

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
    "name": "管理员列表", // 权限名称
    "url": "\/view\/user\/search;\/v1\/user\/search", // 路由
    "status": 1,
    "sort": 3,
    "mtime": "2020-09-11 14:32:25",
    "ctime": "2020-09-08 19:38:52"
  }
}
```  

**备注**  

### 权限列表

**请求 URL**  

http://passport.micro.service.com/v1/permission/search

**请求方式**  

GET  

**请求参数**  

| 字段 | 必填 | 类型 | 描述 |  
| :--- | :---- | :---- | :---- |
| p | 否 | int | 页码，默认为 1 |
| size | 否 | int | 每页条数，默认为 20 |
| id | 否 | int | ID |
| name | 否 | string | 权限名称 |
| url | 否 | string | 路由 |
| status | 否 | int | 状态 |


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
        "name": "管理员列表",
        "url": "\/view\/user\/search;\/v1\/user\/search",
        "status": 1,
        "sort": 3,
        "mtime": "2020-09-11 14:32:25",
        "ctime": "2020-09-08 19:38:52",
        "url_list": [
          "\/view\/user\/search",
          "\/v1\/user\/search"
        ]
      }
    ]
  }
}
```  

**备注**  
