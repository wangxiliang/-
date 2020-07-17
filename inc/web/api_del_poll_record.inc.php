<?php
global $_GPC, $_W;

use Core\Model\PollRecord;

$pollRecord = new PollRecord();
$id = $_GPC['id'];
$uniacid = $_W['uniacid'];
$res = $pollRecord->delPollRecordById($id, $uniacid);

if(empty($res)) return $this->json_err();

$this->json_suc('删除成功');