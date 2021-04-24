<?php
/**
 * File Name: UploadUserAvatarExternal.php
 * ©2020 All right reserved Qiaotongtianxia Network Technology Co., Ltd.
 * @author: hyunsu
 * @date: 2021/4/23 4:49 下午
 * @email: hyunsu@foxmail.com
 * @description:
 * @version: 1.0.0
 * ============================= 版本修正历史记录 ==========================
 * 版 本:          修改时间:          修改人:
 * 修改内容:
 *      //
 */

namespace qh4module\user\external;


use qh4module\upload\external\ExtUpload;

class UploadUserAvatarExternal extends ExtUpload
{
    /**
     * @inheritDoc
     */
    public function attributeLangs()
    {
        return [
            'zh_cn' => [
                'file' => '头像'
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    public function enableExtensions()
    {
        return ['jpg', 'png', 'jpeg'];
    }

    /**
     * @inheritDoc
     */
    public function enableMineType()
    {
        return ['image/jpeg', 'image/png'];
    }

    /**
     * @inheritDoc
     */
    public function sizeRange()
    {
        return [0, 2097152];
    }
}