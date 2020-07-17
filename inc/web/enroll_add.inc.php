<?php
defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
$do_type = $_GPC['do_type'];
$id = $_GPC['id'];
use Core\Model\Enroll;
$enroll = new Enroll;

$data = $do_type == 'edit' ? $enroll->getEnrollById($id, $_W['uniacid']) : [];
include $this->template('web/enroll_add');