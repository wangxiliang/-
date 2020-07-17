<?php
namespace Core\Model;
defined('IN_IA') or exit('Access Denied');

class WechatUser extends Base {
  public $user_table = MODULE_NAME . '_wechat_user';

  public function getUserByOpenid($openid, $uniacid) {
    return $this->query->from($this->user_table)
    ->where(compact('openid', 'uniacid'))
    ->get();
  }

  public function updateUserByOpenid($data, $openid, $uniacid) {
    return pdo_update($this->user_table, $data, compact('openid', 'uniacid'));
  }

  public function addUser($data) {
    return pdo_insert($this->user_table, $data);
  }
}