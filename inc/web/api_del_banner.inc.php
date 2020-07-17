<?php
global $_GPC, $_W;

use Core\Model\Banner;

$banner = new Banner();
$id = $_GPC['id'];
$uniacid = $_W['uniacid'];
$res = $banner->delBannerById($id, $uniacid);

if(empty($res)) return $this->json_err();

$this->json_suc('删除成功');