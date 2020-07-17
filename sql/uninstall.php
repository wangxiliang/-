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
  DROP TABLE IF EXISTS {$table_banner};
  DROP TABLE IF EXISTS {$table_enroll};
  DROP TABLE IF EXISTS {$table_works};
  DROP TABLE IF EXISTS {$table_wechat_user};
  DROP TABLE IF EXISTS {$table_poll};
  DROP TABLE IF EXISTS {$table_poll_record};
  DROP TABLE IF EXISTS {$table_poll_config};
  DROP TABLE IF EXISTS {$table_bgm};
EOD;