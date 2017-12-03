#订单表
CREATE TABLE `o2o_order`(
`id` int(11) unsigned NOT NULL auto_increment,
`out_trade_no` VARCHAR (100) NOT NULL DEFAULT '',
`transaction_id` VARCHAR(100) NOT NULL DEFAULT '',
`username` VARCHAR(50) NOT NULL DEFAULT '',
`pay_time` VARCHAR(20)  NOT NULL DEFAULT '',
`payment_id` int(1) unsigned NOT NULL DEFAULT 1,
`deal_id` int(11) unsigned NOT NULL DEFAULT 0,
`deal_count` int(11) unsigned NOT NULL DEFAULT 0,
`pay_status` tinyint(1) unsigned NOT NULL DEFAULT 1 COMMENT '支付状态 0：未支付， 1：支付成功， 2：支付失败',
`total_price` DECIMAL(20,2) NOT NULL DEFAULT '0.00',
`pay_amount` DECIMAL(20,2) NOT NULL DEFAULT '0.00',
`user_id` INT(11) NOT NULL DEFAULT 0,
`status` tinyint(1) NOT NULL DEFAULT 1,
`referer` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '订单的来路',
`create_time` INT(11) unsigned NOT NULL DEFAULT 0,
`update_time` INT(11) unsigned NOT NULL DEFAULT 0,
PRIMARY KEY (`id`),
UNIQUE `out_trade_no`(`out_trade_no`),
KEY user_id(`user_id`),
KEY create_time(`create_time`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

#消费券表
CREATE TABLE `o2o_coupons`(
`id` int(11) unsigned NOT NULL auto_increment,
`sn` VARCHAR (100) NOT NULL DEFAULT '' COMMENT '消费券的序列号',
`password` VARCHAR(100) NOT NULL DEFAULT '',
`user_id` int(11)  NOT NULL DEFAULT 1,
`deal_id` int(11)  NOT NULL DEFAULT 0,
`order_id` int(11)  NOT NULL DEFAULT 0,
`status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0:未发送给用户 1：已发送给用户  2：用户已经使用了 3：禁用',
`create_time` INT(11) unsigned NOT NULL DEFAULT 0,
`update_time` INT(11) unsigned NOT NULL DEFAULT 0,
PRIMARY KEY (`id`),
UNIQUE `sn`(`sn`),
KEY user_id(`user_id`),
KEY deal_id(`deal_id`),
KEY create_time(`create_time`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


#版本问题表
CREATE TABLE `o2o_version`(
`id` int(11) unsigned NOT NULL auto_increment,
`name` VARCHAR (100) NOT NULL DEFAULT '' ,
`pos` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '位置',
`comment` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '问题描述',
`listorder` int(5) NOT NULL DEFAULT 0 COMMENT '排序、重要程度',
`status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0:未处理 1：已处理  2：棘手 3：其他',
`create_time` INT(11) unsigned NOT NULL DEFAULT 0 COMMENT '产生时间',
`update_time` INT(11) unsigned NOT NULL DEFAULT 0 COMMENT '最近修改时间',
PRIMARY KEY (`id`),
KEY `listorder`(`listorder`),
KEY name(`name`),
KEY status(`status`),
KEY create_time(`create_time`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;