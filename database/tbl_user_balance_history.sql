DROP TABLE IF EXISTS `tbl_user_balance_history`;

CREATE TABLE IF NOT EXISTS `tbl_user_balance_history`
(
    `id`          VARCHAR(64)    NOT NULL,
    `user_id`     VARCHAR(64)    NOT NULL,
    #该项完全根据业务自定义,模块没有使用该字段
    #例如 1购买商品 2 转账支出 3 充值增加 等
    `act`         TINYINT        NOT NULL COMMENT '类型',
    `type`        TINYINT        NOT NULL COMMENT '-1 余额减少\n1 余额增加',
    `price`       DECIMAL(10, 2) NOT NULL COMMENT '变动金额',
    `balance`     DECIMAL(10, 2) NOT NULL COMMENT '变动后余额',
    `create_time` BIGINT         NOT NULL,
    PRIMARY KEY (`id`)
)
    ENGINE = InnoDB
    COMMENT = '用户-余额变动历史记录';

CREATE INDEX `fk_tbl_user_balance_history_tbl_user1_idx` ON `tbl_user_balance_history` (`user_id` ASC);

CREATE INDEX `create_time_index` ON `tbl_user_balance_history` (`create_time` ASC);
