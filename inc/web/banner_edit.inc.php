<?php
global $_GPC, $_W;
use Core\Model\Banner;
$banner = new Banner();
$id = $_GPC['id'];
$uniacid = $_W['uniacid'];
$data = $banner->getBannerById($id, $uniacid);

include $this->template('web/banner_edit');