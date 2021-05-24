<?php
/**
 * File Name: GetBasicInfo.php
 * ©2020 All right reserved Qiaotongtianxia Network Technology Co., Ltd.
 * @author: hyunsu
 * @date: 2021/4/23 4:27 下午
 * @email: hyunsu@foxmail.com
 * @description:
 * @version: 1.0.0
 * ============================= 版本修正历史记录 ==========================
 * 版 本:          修改时间:          修改人:
 * 修改内容:
 *      //
 */

namespace qh4module\user\models;


use qh4module\token\TokenFilter;
use qh4module\user\external\ExtUser;
use qttx\web\ServiceModel;

/**
 * Class GetBasicInfo
 * @package qh4module\user\models
 * @property ExtUser $external
 */
class GetBasicInfo extends ServiceModel
{
    /**
     * @var string 接收参数,获取用户信息,不传入则默认获取自己的信息
     */
    public $user_id;


    public function run()
    {
        $tb_user = $this->external->userTableName();
        $tb_info = $this->external->userInfoTableName();

        if (empty($this->user_id)) {
            $this->user_id = TokenFilter::getPayload('user_id');
        }

        $result = $this->external->getDb()
            ->select($this->external->basicInfoField())
            ->from("$tb_user")
            ->leftJoin("$tb_info", "{$tb_user}.id={$tb_info}.user_id")
            ->whereArray(['id' => $this->user_id])
            ->row();

        if ($result['mobile']) {
            $result['mobile'] = substr_replace($result['mobile'], '****', 3, 4);
        }
        if ($result['city_id']) {
            $result['city_id_path'] = [];
            $result_city = \QTTX::$app->db
                ->select(['parent_path'])
                ->from($this->external->cityTableName())
                ->whereArray(['id' => $result['city_id']])
                ->row();
            $ary = explode(',', $result_city['parent_path']);
            foreach ($ary as $item) {
                $result['city_id_path'][] = intval($item);
            }
        }

        return $result;
    }
}