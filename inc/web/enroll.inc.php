<?php
global $_GPC, $_W;

use Core\Model\Enroll;
$enroll = new Enroll();
$uniacid = $_W['uniacid'];
$page = $_GPC['page'] ? $_GPC['page'] : 1;
$list = $enroll->getEnrollList($page, $uniacid);
$total = $enroll->getEnrollTotal($uniacid);

include $this->template('web/enroll');