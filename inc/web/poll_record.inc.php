<?php
global $_GPC, $_W;

use Core\Model\PollRecord;
$pollRecord = new PollRecord();
$uniacid = $_W['uniacid'];
$page = $_GPC['page'] ? $_GPC['page'] : 1;
$list = $pollRecord->getPollRecordList($page, $uniacid);
$total = $pollRecord->getPollRecordTotal($uniacid);
include $this->template('web/poll_record');