<?php

defined('MODULE_NAME') or define('MODULE_NAME', 'zyun_vote');

// banner 表 用于存放 banner图路径 

$table_banner = tablename(MODULE_NAME . '_banner');

// 投票报名

$table_enroll = tablename(MODULE_NAME . '_enroll');

// 报名作品

$table_works = tablename(MODULE_NAME . '_works');

// 微信用户表

$table_wechat_user = tablename(MODULE_NAME . '_wechat_user');

// 投票数量表

$table_poll = tablename(MODULE_NAME . '_poll');

// 投票记录表

$table_poll_record = tablename(MODULE_NAME . '_poll_record');

// 投票活动配置表

$table_poll_config = tablename(MODULE_NAME . '_config');

// 投票活动背景音乐

$table_bgm = tablename(MODULE_NAME . '_bgm');



$sql = <<<EOD

  CREATE TABLE IF NOT EXISTS {$table_banner}(

    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,

    uniacid int(11) UNSIGNED not null,

    sort int(10) UNSIGNED DEFAULT 0,

    src VARCHAR(500),

    redirect_url VARCHAR(500),

    type TINYINT(1) UNSIGNED DEFAULT 1,

    create_time int(11) UNSIGNED NOT NULL,

    PRIMARY KEY(`id`)

  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=`utf8`;



  CREATE TABLE IF NOT EXISTS {$table_enroll}(

    `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,

    `uniacid` INT(11) UNSIGNED,

    `openid` VARCHAR(521),

    `user_id` INT(11) UNSIGNED,

    `name` VARCHAR(20),

    `phone` CHAR(11),

    `sub` VARCHAR(255),

    `title` VARCHAR(100),

    `sex` TINYINT(1) UNSIGNED DEFAULT NULL,

    `avatar` VARCHAR(500),

    create_time int(11) UNSIGNED,

    update_time int(11) UNSIGNED,

    PRIMARY KEY(`id`)

  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=`utf8`;

  

  CREATE TABLE IF NOT EXISTS {$table_works}(

    `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,

    `enroll_id` INT(11) UNSIGNED,

    `src` VARCHAR(500),

    `uniacid` INT(11),

    `type` TINYINT(1) UNSIGNED DEFAULT 1,

    `video_img` VARCHAR(500) COMMENT '视频封面',

    `uniacid` INT(11) UNSIGNED,

    create_time int(11) UNSIGNED,

    update_time int(11) UNSIGNED,

    PRIMARY KEY(`id`)

  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=`utf8`;



  CREATE TABLE IF NOT EXISTS {$table_wechat_user}(

    `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,

    `openid` varchar(512),

    `uniacid` INT(11) UNSIGNED,

    `nickname` VARCHAR(255),

    `sex` TINYINT(1),

    `headimgurl` VARCHAR(500),

    `subscribe` TINYINT(1) UNSIGNED DEFAULT 0,

    `subscribe_time` INT(11) UNSIGNED,

    create_time int(11) UNSIGNED,

    PRIMARY KEY(`id`)

  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=`utf8`;



  CREATE TABLE IF NOT EXISTS {$table_poll}(

    `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,

    `openid` VARCHAR(521),

    `user_id` BIGINT(20) UNSIGNED,

    `uniacid` INT(11),

    `enroll_id` BIGINT(20) UNSIGNED,

    `poll` int(11) UNSIGNED DEFAULT 0,

    `create_time` int(11) UNSIGNED,

    `update_time` int(11) UNSIGNED,

    PRIMARY KEY(`id`)

  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=`utf8`;



  CREATE TABLE IF NOT EXISTS {$table_poll_record}(

    `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,

    `poll_id` INT(11) UNSIGNED,

    `user_id` INT(11) UNSIGNED,

    `uniacid` INT(11),

    `poll_user_id` INT(11) UNSIGNED,

    `poll_num` INT(11) UNSIGNED DEFAULT 0,

    `username` VARCHAR(50),

    `title` VARCHAR(255),

    create_time int(11) UNSIGNED,

    PRIMARY KEY(`id`)

  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=`utf8`;



  CREATE TABLE IF NOT EXISTS {$table_poll_config}(

    `id` SMALLINT(6) UNSIGNED NOT NULL AUTO_INCREMENT,

    `uniacid` INT(11),

    `url` VARCHAR(500) COMMENT '投票生成链接',

    `title` VARCHAR(255) COMMENT '投票活动标题',

    `content` text,

    `poll_time` INT(11) UNSIGNED DEFAULT 24 COMMENT '投票间隔时间 默认24小时',

    `poll_start_time` INT(11) UNSIGNED COMMENT '投票开始时间',

    `poll_end_time` INT(11) UNSIGNED COMMENT '投票结束时间',

    `poll_num` INT(11) UNSIGNED DEFAULT 1 COMMENT '用户可对单个作品投票次数', 

    `poll_total` INT(11) UNSIGNED DEFAULT 1 COMMENT '用户每日可投总票数',

    `brand_name` VARCHAR(50) COMMENT '活动支持方',

    `enroll_status` TINYINT(1) UNSIGNED DEFAULT 0 COMMENT '线上报名开关',

    `bgm_status` TINYINT(1) UNSIGNED DEFAULT 0 COMMENT '背景音乐开关',

    `bgm_src` VARCHAR(500) COMMENT '背景音乐链接地址',

    `subscribe_status` TINYINT(1) UNSIGNED DEFAULT 0 COMMENT '是否强制关注公众号',

    `official_qrcode` VARCHAR(500) COMMENT '公众号二维码',

    `official_qrcode_sub` VARCHAR(255) COMMENT '公众号二维码描述',

    `poll_type` TINYINT(1) UNSIGNED DEFAULT 1 COMMENT '投票活动类型：1 图片，2视频，3视频图片混合',

    `share_status` TINYINT(1) UNSIGNED DEFAULT 0,

    `share_img` VARCHAR(500) COMMENT '全局分享接口',

    `share_title` VARCHAR(50) COMMENT '全局分享标题',

    `share_sub` VARCHAR(50) COMMENT '全局分享描述',

    `create_time` int(11) UNSIGNED,

    `update_time` int(11) UNSIGNED,

    PRIMARY KEY(`id`)

  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=`utf8`;



  CREATE TABLE IF NOT EXISTS {$table_bgm}(

    `id` SMALLINT(6) UNSIGNED NOT NULL AUTO_INCREMENT,

    `uniacid` INT(11) UNSIGNED,

    `src` VARCHAR(500) COMMENT '背景音乐地址',

    create_time int(11) UNSIGNED,

    PRIMARY KEY(`id`)

  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=`utf8`;

EOD;





$result = pdo_run($sql);