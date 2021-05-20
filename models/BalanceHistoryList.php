<?php
/**
 * File Name: BalanceHistoryList.php
 * ©2020 All right reserved Qiaotongtianxia Network Technology Co., Ltd.
 * @author: hyunsu
 * @date: 2021/5/11 4:57 下午
 * @email: hyunsu@foxmail.com
 * @description:
 * @version: 1.0.0
 * ============================= 版本修正历史记录 ==========================
 * 版 本:          修改时间:          修改人:
 * 修改内容:
 *      //
 */

namespace qh4module\user\models;


use qh4module\user\external\ExtUser;
use qttx\web\ServiceModel;

class BalanceHistoryList extends ServiceModel
{
    /**
     * @var int 接收参数,页数
     */
    public $page = 1;

    /**
     * @var int 接收参数,每页数量
     */
    public $limit = 20;

    /**
     * @var int 接收参数,作为筛选条件
     */
    public $act;

    /**
     * @var int 接收参数,作为筛选条件
     * -1 减少  1增加
     */
    public $type;

    /**
     * @var int 接收参数,作为时间的筛选条件
     * 需要时间戳
     */
    public $start_time;

    /**
     * @var int 接收参数,作为时间筛选条件
     * 需要时间戳
     */
    public $end_time;

    /**
     * @var string 指定用户
     */
    public $user_id;

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
            [['page','limit','act','start','end_time'],'integer'],
            [['type'],'in','range'=>[-1,1]],
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributeLangs()
    {
        return [
            'page'=>'页数',
            'limit'=>'每页数量',
            'act'=>'余额类型',
            'type'=>'类型',
            'start_time'=>'开始时间',
            'end_time'=>'接收时间'
        ];
    }

    /**
     * @inheritDoc
     */
    public function run()
    {
        $sql = $this->external->getDb()
            ->select('*')
            ->from($this->external->balanceHistoryTableName())
            ->whereArray(['user_id' => $this->user_id]);
        if ($this->act) {
            $sql->where('act= :act')
                ->bindValue('act', $this->act);
        }
        if ($this->type) {
            $sql->where('type= :type')
                ->bindValue('type', $this->type);
        }
        if ($this->start_time) {
            $this->start_time = strtotime(date('Y-m-d 00:00:00', $this->start_time));
            $sql->where('create_time >= :t1')
                ->bindValue('t1', $this->start_time);
        }
        if ($this->end_time) {
            $this->end_time = strtotime(date('Y-m-d 23:59:59', $this->end_time));
            $sql->where('create_time <= :t2')
                ->bindValue('t2', $this->end_time);
        }
        $result = $sql->orderByDESC(['create_time'])
            ->offset(($this->page - 1) * $this->limit)
            ->limit($this->limit)
            ->query();

        return $result;
    }
}