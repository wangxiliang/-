<?php
use Core\Model\Banner;
global $_GPC, $_W;

$banner = new Banner();
$page = $_GPC['page'] ? $_GPC['page'] : 1;
$list = $banner->getBannerList($page, $_W['uniacid']);
$total = $banner->getBanerTotal($_W['uniacid']);
include $this->template('web/banner');