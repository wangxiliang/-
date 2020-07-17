<?php
global $_GPC, $_W;

use Core\Model\Banner;
$banner = new Banner();
$id = $_GPC['id'];
$type = $_GPC['type'];
$redirect_url = $_GPC['redirect_url'];
$src = $_GPC['src'];
$uniacid = $_W['uniacid'];

// 请求操作类型  sort
$do_type = $_GPC['do_type'];
if(!empty($do_type) && $do_type == 'sort') {
  $sort = $_GPC['sort'];
  if(!is_numeric($sort)) return $this->json_err('排序值请填写数字');

  $res = $banner->updateBannerById(compact('sort'), $id, $uniacid);

  if(empty($res)) return $this->json_err('更新失败，服务器异常');

  $this->json_suc('更新成功');

}



if(empty($id)) {
  $this->json_err('非法请求');
}

if(!empty($redirect_url)) {
  $preg = "/^http(s)?:\\/\\/.+/";
  preg_match($preg, $redirect_url) ? '' : $this->json_err('跳转链接请以http或https开头');
}

if(empty($src)) {
  $this->json_err('请上传图片');
}



$res = $banner->updateBannerById(compact('type', 'redirect_url', 'src'), $id, $uniacid);

if(empty($res)) return $this->json_err('更新失败，服务器异常');

$this->json_suc('更新成功');