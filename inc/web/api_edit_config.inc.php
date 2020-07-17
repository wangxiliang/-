<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;

use Core\Model\Config;
$config = new Config;

$url = $_GPC['url'];
$poll_type = $_GPC['poll_type'];
$title = $_GPC['title'];
$brand_name = $_GPC['brand_name'];
$poll_start_time = strtotime($_GPC['poll_start_time']);
$poll_end_time = strtotime($_GPC['poll_end_time']);
$poll_total = $_GPC['poll_total'];
$poll_num = $_GPC['poll_num'];
$enroll_status = $_GPC['enroll_status'];
$bgm_status = $_GPC['bgm_status'];
$subscribe_status = $_GPC['subscribe_status'];
$bgm_src = $_GPC['bgm_src'];
$official_qrcode = $_GPC['official_qrcode'];
$official_qrcode_sub = $_GPC['official_qrcode_sub'];
$content = htmlspecialchars_decode($_GPC['content']);
$uniacid = $_W['uniacid'];

$data = $config->getConfig($uniacid);

$configData = compact(
  'url', 
  'poll_type', 
  'title', 
  'brand_name', 
  'poll_start_time', 
  'poll_end_time',
  'poll_total',
  'poll_num',
  'enroll_status',
  'bgm_status',
  'subscribe_status',
  'bgm_src',
  'official_qrcode',
  'official_qrcode_sub',
  'content'
);
$res = empty($data) ? $config->addConfig($configData) : $config->updateConfig($configData, $uniacid);


if(empty($res)) return $this->json_err();

$this->json_suc('保存成功');





