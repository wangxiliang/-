<?php
global $_GPC, $_W;
use Core\Model\Enroll;
use Core\Common\Utils;
$enroll = new Enroll();

$type = $_GPC['type'];
$name = $_GPC['name'];
$phone = $_GPC['phone'];
$poll = $_GPC['poll'];
$sex = $_GPC['sex'];
$title = $_GPC['title'];
$src = $_GPC['src'];
$video_img = $_GPC['video_img'];
$sub = htmlspecialchars_decode($_GPC['sub']);
$do_type = $_GPC['do_type'];
$id = $_GPC['id'];
// 测试
$openid = '1asd';
$user_id = 1;
// -----

$uniacid = $_W['uniacid'];

$data = [
  'enroll' => compact('name', 'phone','sex', 'title',  'sub', 'uniacid','openid', 'user_id'),
  'poll' => $poll,
  'work' => compact('type', 'src', 'video_img'),
];



$whiteList = ['video_img', 'sub', 'sex'];

$vali = compact('type', 'src', 'video_img', 'name', 'phone', 'sex', 'title',  'sub', 'uniacid','openid', 'user_id');

foreach($vali as $key => $value) {
  if(empty($value) && !in_array($key, $whiteList)) {
    $this->json_err('表单必填项不能为空');
    break;
  }
}

// 校验手机号
if(!Utils::checkMobile($phone)) return $this->json_err('手机号格式不正确');

// 根据 do_type 判断是否为更新或新增
$res =  $do_type == 'add' ? $enroll->addEnroll($data) : $enroll->updateEnrollById($data, $id, $uniacid);


if(empty($res)) return $this->json_err('操作失败，服务器异常');

return $this->json_suc('操作成功');
