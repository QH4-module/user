<?php
/**
 * File Name: TraitUserController.php
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

namespace qh4module\user;


use qh4module\upload\models\UploadModel;
use qh4module\user\external\ExtUser;
use qh4module\user\external\UploadUserAvatarExternal;
use qh4module\user\models\ChangePassword;
use qh4module\user\models\GetBasicInfo;
use qh4module\user\models\SetBasicInfo;

trait TraitUserController
{
    /**
     * 扩展类
     * @return ExtUser
     */
    public function ext_user()
    {
        return new ExtUser();
    }

    /**
     * 获取用户的基本信息
     * @return mixed
     */
    public function actionGetBasicInfo()
    {
        $model = new GetBasicInfo([
            'external' => $this->ext_user(),
        ]);

        return $this->runModel($model);
    }

    /**
     * 设置用户的基本信息
     * @return array
     */
    public function actionSetBasicInfo()
    {
        $model = new SetBasicInfo([
            'external' => $this->ext_user(),
        ]);

        return $this->runModel($model);
    }


    /**
     * 更改密码
     * @return array
     */
    public function actionChangePassword()
    {
        $model = new ChangePassword([
            'external' => $this->ext_user(),
        ]);

        return $this->runModel($model);
    }

    /**
     * 上传头像
     * @return array
     */
    public function actionUploadAvatar()
    {
        $model = new UploadModel([
            'external' => new UploadUserAvatarExternal(),
        ]);

        return $this->runModel($model);
    }

}
