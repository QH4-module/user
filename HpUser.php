<?php
/**
 * File Name: HpUser.php
 * ©2020 All right reserved Qiaotongtianxia Network Technology Co., Ltd.
 * @author: hyunsu
 * @date: 2021/5/11 4:20 下午
 * @email: hyunsu@foxmail.com
 * @description:
 * @version: 1.0.0
 * ============================= 版本修正历史记录 ==========================
 * 版 本:          修改时间:          修改人:
 * 修改内容:
 *      //
 */

namespace qh4module\user;


use qh4module\user\external\ExtUser;
use qttx\components\db\DbModel;
use qttx\exceptions\InvalidArgumentException;

class HpUser
{
    /**
     * 减少用户余额
     * 调用该函数,务必开启事务和异常处理
     * @param string $user_id
     * @param float $price 金额,单位元,支持2位小数
     * @param int $act 对应数据表的act字段,完全自定义,作为类型使用
     * @param DbModel $db 开启事务的数据库操作句柄
     * @param ExtUser|null $external
     * @return bool 成功返回true
     *              返回false表示用户余额不足
     */
    public static function decrBalance($user_id, $price, $act, $db, ExtUser $external = null)
    {
        if ($price < 0) {
            throw new InvalidArgumentException('减少的余额必须大于0');
        }
        if (empty($external)) $external = new ExtUser();

        $result = $db->select('balance')
            ->from($external->userInfoTableName())
            ->whereArray(['user_id' => $user_id])
            ->row();
        if ($result['balance'] < $price) {
            return false;
        }

        // 增加记录
        $db->insert($external->balanceHistoryTableName())
            ->cols([
                'id' => \QTTX::$app->snowflake->id(),
                'user_id' => $user_id,
                'act' => $act,
                'type' => -1,
                'price' => $price,
                'balance' => $result['balance'] - $price,
                'create_time' => time(),
            ])
            ->query();

        // 更新余额
        $db->update($external->userInfoTableName())
            ->col('balance', $result['balance'] - $price)
            ->whereArray(['user_id' => $user_id])
            ->query();

        return true;
    }


    /**
     * 增加用户余额
     * 调用该函数,务必开启事务和异常处理
     * @param string $user_id
     * @param float $price 变动金额,单位元,最多2位小数
     * @param int $act 对应数据表的act字段,完全自定义,作为类型使用
     * @param DbModel $db 开启事务的数据库操作句柄
     * @param ExtUser|null $external
     */
    public static function incrBalance($user_id, $price, $act, $db, ExtUser $external = null)
    {
        if ($price < 0) {
            throw new InvalidArgumentException('增加的余额必须大于0');
        }
        if (empty($external)) $external = new ExtUser();

        $result = $db->select('balance')
            ->from($external->userInfoTableName())
            ->whereArray(['user_id' => $user_id])
            ->row();

        // 增加记录
        $db->insert($external->balanceHistoryTableName())
            ->cols([
                'id' => \QTTX::$app->snowflake->id(),
                'user_id' => $user_id,
                'act' => $act,
                'type' => 1,
                'price' => $price,
                'balance' => $result['balance'] + $price,
                'create_time' => time(),
            ])
            ->query();

        // 更新余额
        $db->update($external->userInfoTableName())
            ->col('balance', $result['balance'] + $price)
            ->whereArray(['user_id' => $user_id])
            ->query();
    }

    /**
     * 减少用户积分
     * 调用该函数,务必开启事务和异常处理
     * @param string $user_id
     * @param float $point 变动的积分,支持2位小数
     * @param int $act 对应数据表的act字段,完全自定义,作为类型使用
     * @param DbModel $db 开启事务的数据库操作句柄
     * @param ExtUser|null $external
     * @return bool 成功返回true
     *              返回false表示用户积分
     * @return bool
     */
    public static function decrScores($user_id, $point, $act, $db, ExtUser $external = null)
    {
        if ($point < 0) {
            throw new InvalidArgumentException('减少的积分必须大于0');
        }
        if (empty($external)) $external = new ExtUser();

        $result = $db->select('scores')
            ->from($external->userInfoTableName())
            ->whereArray(['user_id' => $user_id])
            ->row();
        if ($result['scores'] < $point) {
            return false;
        }

        // 增加记录
        $db->insert($external->scoresHistoryTableName())
            ->cols([
                'id' => \QTTX::$app->snowflake->id(),
                'user_id' => $user_id,
                'act' => $act,
                'type' => -1,
                'point' => $point,
                'scores' => $result['scores'] - $point,
                'create_time' => time(),
            ])
            ->query();

        // 更新积分
        $db->update($external->userInfoTableName())
            ->col('scores', $result['scores'] - $point)
            ->whereArray(['user_id' => $user_id])
            ->query();

        return true;
    }

    /**
     * 增加用户积分
     * 调用该函数,务必开启事务和异常处理
     * @param string $user_id
     * @param float $point 变动积分,最多2位小数
     * @param int $act 对应数据表的act字段,完全自定义,作为类型使用
     * @param DbModel $db 开启事务的数据库操作句柄
     * @param ExtUser|null $external
     */
    public static function incrScores($user_id, $point, $act, $db, ExtUser $external = null)
    {
        if ($point < 0) {
            throw new InvalidArgumentException('增加的积分必须大于0');
        }
        if (empty($external)) $external = new ExtUser();

        $result = $db->select('scores')
            ->from($external->userInfoTableName())
            ->whereArray(['user_id' => $user_id])
            ->row();

        // 增加记录
        $db->insert($external->scoresHistoryTableName())
            ->cols([
                'id' => \QTTX::$app->snowflake->id(),
                'user_id' => $user_id,
                'act' => $act,
                'type' => 1,
                'point' => $point,
                'scores' => $result['scores'] + $point,
                'create_time' => time(),
            ])
            ->query();

        // 更新积分
        $db->update($external->userInfoTableName())
            ->col('scores', $result['scores'] + $point)
            ->whereArray(['user_id' => $user_id])
            ->query();
    }
}