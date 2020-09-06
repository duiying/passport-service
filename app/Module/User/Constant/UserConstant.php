<?php

namespace App\Module\User\Constant;

class UserConstant
{
    /**
     * 状态
     */
    const USER_STATUS_DELETE = -1;              // 删除
    const USER_STATUS_NORMAL = 1;               // 正常

    /**
     * ROOT 用户
     */
    const IS_ROOT   = 1;                        // 是
    const NOT_ROOT  = 0;                        // 否
}