<?php
global $_GPC, $_W;

use Core\Model\Enroll;

$enroll = new Enroll();
$id = $_GPC['id'];
$uniacid = $_W['uniacid'];
$res = $enroll->delEnrollById($id, $uniacid);

if(empty($res)) return $this->json_err();

$this->json_suc('删除成功');