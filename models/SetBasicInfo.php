<?php
/**
 * File Name: SetBasicInfo.php
 * ©2020 All right reserved Qiaotongtianxia Network Technology Co., Ltd.
 * @author: hyunsu
 * @date: 2021/4/23 4:38 下午
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

class SetBasicInfo extends ServiceModel
{

    /**
     * @var string 接收参数,必须:名字
     */
    public $nick_name;

    /**
     * @var int 接收参数,非必须,所属地区
     */
    public $city_id = 0;

    /**
     * @var int 接收参数,非必须,性别
     */
    public $gender = 0;

    /**
     * @var string 接收参数,非必须,生日
     */
    public $birthday;

    /**
     * @var string 接收参数,非必须,个人说明
     */
    public $description = '';

    /**
     * @var string 接收参数,非必须,头像
     */
    public $avatar = '';


    /**
     * @var ExtUser
     */
    protected $external;


    public function rules()
    {
        return [
            [['nick_name'], 'string', ['max' => 20]],
            [['gender'], 'in', 'range' => [0, 1, 2]],
            [['avatar'], 'string', ['max' => 500]],
            [['city_id'], 'integer'],
            [['birthday'], 'match', 'pattern' => '/\d+-\d+-\d+/'],
            [['description'], 'string', ['max' => 1000]],
        ];
    }


    public function run()
    {
        $db = $this->external->getDb();

        $db->beginTrans();

        try {

            $user_id = TokenFilter::getPayload('user_id');

            $this->external->getDb()
                ->update($this->external->userInfoTableName())
                ->cols([
                    'nick_name' => $this->nick_name,
                    'avatar' => $this->avatar,
                    'gender' => $this->gender,
                    'birthday' => $this->birthday,
                    'description' => $this->description,
                    'city_id' => $this->city_id
                ])
                ->whereArray(['user_id'=>$user_id])
                ->query();

            $this->external->onInfoChange($user_id, $db);

            $db->commitTrans();

            return true;

        } catch (\Exception $exception) {
            $db->rollBackTrans();
            throw $exception;
        }
    }
}