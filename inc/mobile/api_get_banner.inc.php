<?php

defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;

use Core\Model\Banner;
$banner = new Banner();
$type = $_GPC['type'];
$list = $banner->getBannerByType($type, $_W['uniacid']);

$this->json_suc('', $list);
