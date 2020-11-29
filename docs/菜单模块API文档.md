# 菜单模块API文档

### 目录

- [创建菜单](#创建菜单)
- [更新菜单](#更新菜单)
- [菜单详情](#菜单详情)
- [更新菜单部分字段](#更新菜单部分字段)
- [菜单列表](#菜单列表)

### 创建菜单

**请求 URL**  

http://passport.micro.service.com/v1/menu/create

**请求方式**  

POST  

**请求参数**  

| 字段 | 必填 | 类型 | 描述 |  
| :--- | :---- | :---- | :---- |
| pid | 是 | int | 父级ID {0：顶级菜单；} |
| name | 是 | string | 菜单名称 |
| icon | 是 | string | 菜单图标 |
| url | 否 | string | 路由 |
| sort | 否 | int | 排序 |

**返回值**  

```json
{
  "code": 0,
  "msg": "",
  "data": 6
}
```  

**备注**  
- 一级菜单不需要路由
- 二级菜单必须输入路由

### 更新菜单

**请求 URL**  

http://passport.micro.service.com/v1/menu/update

**请求方式**  

POST  

**请求参数**  

| 字段 | 必填 | 类型 | 描述 |  
| :--- | :---- | :---- | :---- |
| id | 是 | int | ID |
| pid | 是 | int | 父级ID {0：顶级菜单；} |
| name | 是 | string | 菜单名称 |
| icon | 是 | string | 菜单图标 |
| url | 否 | string | 路由 |
| sort | 否 | int | 排序 |

**返回值**  

```json
{
  "code": 0,
  "msg": "",
  "data": 1
}
```  

**备注**  
- 一级菜单不需要路由
- 二级菜单必须输入路由

### 菜单详情

**请求 URL**  

http://passport.micro.service.com/v1/menu/find

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
    "id": 6, // ID
    "pid": 0, // 父级ID {0：顶级菜单；}
    "name": "测试菜单", // 名称
    "icon": "123", // icon
    "url": "", // URL
    "status": 1,
    "sort": 99,
    "mtime": "2020-11-29 10:23:36",
    "ctime": "2020-11-29 10:20:40"
  }
}
```  

**备注**

### 更新菜单部分字段

**请求 URL**  

http://passport.micro.service.com/v1/menu/update_field

**请求方式**  

POST  

**请求参数**  

| 字段 | 必填 | 类型 | 描述 |  
| :--- | :---- | :---- | :---- |
| id | 是 | int | ID |
| sort | 否 | int | 排序 |
| status | 否 | int | 状态 |

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
- 如果是删除一级菜单，需要先删除下面的二级菜单
- 该接口目前只有删除菜单功能在用

### 菜单列表

**请求 URL**  

http://passport.micro.service.com/v1/menu/search

**请求方式**  

GET  

**请求参数**  

| 字段 | 必填 | 类型 | 描述 |  
| :--- | :---- | :---- | :---- |
| pid | 否 | int | 父级ID {0：顶级菜单；} |

**返回值**  

```json
{
  "code": 0,
  "msg": "",
  "data": {
    "list": [ // 菜单列表
      {
        "id": 1,
        "pid": 0,
        "name": "权限管理",
        "icon": "fa fa-tasks",
        "url": "",
        "status": 1,
        "sort": 99,
        "mtime": "2020-08-31 21:12:15",
        "ctime": "2020-08-31 21:11:51",
        "sub_menu_list": [ // 二级菜单列表
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

- 如果有 pid 参数，查询指定 pid 下的菜单列表
