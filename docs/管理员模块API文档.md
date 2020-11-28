# 管理员模块API文档

### 目录

- [创建管理员](#创建管理员)

### 创建管理员

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
- 密码最短长度为 6
- 需要校验邮箱格式
- 需要校验 role_id 是否有效
- 邮箱作为登录的唯一标识，需要校验是否重复
- 密码需要加密
- 创建用户和创建用户角色需要在事务中执行，保证原子性
