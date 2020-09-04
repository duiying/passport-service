<?php

namespace App\Constant;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 */
class AppErrorCode extends AbstractConstants
{
    /******************** 公共错误码 begin 30001 ~ 30500 ****************************************************************/

    /**
     * @Message("请求参数错误")
     */
    const REQUEST_PARAMS_INVALID = 30001;

    /******************** 公共错误码 end ********************************************************************************/

    /******************** 角色模块错误码 begin 3000001 ~ 3000100 *********************************************************/

    /**
     * @Message("创建角色失败！")
     */
    const CREATE_ROLE_ERROR = 3000001;

    /**
     * @Message("角色不存在！")
     */
    const ROLE_NOT_EXIST_ERROR = 3000002;

    /**
     * @Message("超级管理员不允许修改！")
     */
    const ROLE_ADMIN_UPDATE_ERROR = 3000003;

    /**
     * @Message("角色名称已存在！")
     */
    const ROLE_NAME_REPEAT_ERROR = 3000004;

    /******************** 角色模块错误码 end *****************************************************************************/

    /******************** 权限模块错误码 begin 3000101 ~ 3000200 *********************************************************/

    /**
     * @Message("权限不存在！")
     */
    const PERMISSION_NOT_EXIST_ERROR = 3000101;

    /******************** 权限模块错误码 end *****************************************************************************/
}