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
        return '{{%user}}';
    }

    /**
     * @return string 用户信息表
     */
    public function userInfoTableName()
    {
        return '{{%user_info}}';
    }

    /**
     * @return string `tbl_user_balance_history` 用户余额历史表
     */
    public function balanceHistoryTableName()
    {
        return '{{%user_balance_history}}';
    }

    /**
     * @return string `tbl_user_scores_history` 用户积分历史表
     */
    public function scoresHistoryTableName()
    {
        return '{{%user_scores_history}}';
    }

    /**
     * 获取基础信息时返回的字段
     * 可以同时返回 `tbl_user`和`tbl_user_info表的信息`,如果两个表有重复字段,请加表前缀
     * @return string[]
     */
    public function basicInfoField()
    {
        return ['id', 'account', 'mobile', 'email', 'nick_name', 'avatar', 'gender', 'birthday', 'balance', 'scores', 'level', 'city_id'];

        // 如果有重复字段,应该用下面的格式
//        return ['tbl_user.field','tbl_user_info.field']
    }




}