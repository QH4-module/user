<?php
/**
 * File Name: ChangePassword.php
 * ©2020 All right reserved Qiaotongtianxia Network Technology Co., Ltd.
 * @author: hyunsu
 * @date: 2021/4/24 8:51 上午
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
use qttx\helper\StringHelper;
use qttx\web\ServiceModel;

class ChangePassword extends ServiceModel
{

    public $new_password;

    public $old_password;

    public $repeat_password;

    /**
     * @var ExtUser
     */
    protected $external;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            [['new_password','old_password'],'required'],
            [['new_password'],'compare',[
                'compareAttribute'=>'old_password',
                'operator'=>'!=',
                'message' => '新密码和旧密码不能相同',
            ]],
            [['repeat_password'],'compare',[
                'compareAttribute'=>'new_password',
                'message'=>'两次新密码输入不一致'
            ]],
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributeLangs()
    {
        return [
            'old_password'=>'旧密码',
            'new_password'=>'新密码',
            'repeat_password'=>'重复密码'
        ];
    }


    public function run()
    {
        $user_id = TokenFilter::getPayload('user_id');

        $result = $this->external->getDb()
            ->select(['id', 'password', 'salt'])
            ->from($this->external->userTableName())
            ->whereArray(['id' => $user_id])
            ->row();

        if (md5($result['salt'] . $this->old_password) !== $result['password']) {
            $this->addError('old_password', '旧密码错误');
            return false;
        }

        $salt = StringHelper::random(8);
        $password = md5($salt . $this->new_password);

        $this->external->getDb()
            ->update($this->external->userTableName())
            ->cols([
                'salt' => $salt,
                'password' => $password
            ])
            ->whereArray(['id' => $user_id])
            ->query();

        return true;
    }
}