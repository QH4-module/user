<?php
/**
 * File Name: ExtUser.php
 * ©2020 All right reserved Qiaotongtianxia Network Technology Co., Ltd.
 * @author: hyunsu
 * @date: 2021/4/23 4:04 下午
 * @email: hyunsu@foxmail.com
 * @description:
 * @version: 1.0.0
 * ============================= 版本修正历史记录 ==========================
 * 版 本:          修改时间:          修改人:
 * 修改内容:
 *      //
 */

namespace qh4module\user\external;


use qttx\web\External;

class ExtUser extends External
{
    /**
     * @return string 用户表
     */
    public function userTableName()
    {
        return '{{%bk_user}}';
    }

    /**
     * @return string 用户信息表
     */
    public function userInfoTableName()
    {
        return '{{%bk_user_info}}';
    }
}