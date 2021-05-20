DROP TABLE IF EXISTS `tbl_user_scores_history`;

CREATE TABLE IF NOT EXISTS `tbl_user_scores_history`
(
    `id`          VARCHAR(64)    NOT NULL,
    `user_id`     VARCHAR(64)    NOT NULL,
    #该项完全根据业务自定义,模块没有使用该字段
    #例如 1购买商品增加 2 兑换减少
    `act`         TINYINT        NOT NULL COMMENT '类型',
    `type`        TINYINT        NOT NULL COMMENT '-1 积分减少\n1 积分增加',
    `point`       DECIMAL(10, 2) NOT NULL COMMENT '变动点击',
    `scores`      DECIMAL(10, 2) NOT NULL COMMENT '变动后积分',
    `create_time` BIGINT         NOT NULL,
    PRIMARY KEY (`id`)
)
    ENGINE = InnoDB
    COMMENT = '用户-积分变动历史记录';

CREATE INDEX `fk_tbl_user_balance_history_tbl_user1_idx` ON `tbl_user_scores_history` (`user_id` ASC);

CREATE INDEX `create_time_index` ON `tbl_user_scores_history` (`create_time` ASC);
