<?php

global $_GPC, $_W;

use Core\Model\Banner;
$type = $_GPC['type'];
$redirect_url = $_GPC['redirect_url'];
$src = $_GPC['src'];
$uniacid = $_W['uniacid'];
$create_time = time();

if(empty($src)) {
  $this->json_err('请上传图片');
}

if($redirect_url) {
  $preg = "/^http(s)?:\\/\\/.+/";
  preg_match($preg, $redirect_url) ? '' : $this->json_err('跳转链接请以http或https开头');
}

$banner = new Banner();

$res = $banner->addBanner(compact('type', 'redirect_url', 'src', 'uniacid', 'create_time'));

if(empty($res)) return $this->json_err('添加失败，服务器异常');

$this->json_suc('添加成功');

