<?php

defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
use Core\Model\WechatUser;
// 
$uniacid = $_W['uniacid'];
$wechat_user = new WechatUser;
$user_info = mc_oauth_userinfo($uniacid);
if (!empty($user_info)) {
  $openid = $user_info['openid'];
  $result_user = $wechat_user->getUserByOpenid($openid, $uniacid);
  if (!empty($result_user)) {
    $update_data = [
      'subscribe' => $_W['fans']['follow'],
      'nickname' => $user_info['nickname'],
      'headimgurl' => $user_info['avatar'],
      'sex' => $user_info['sex'],
      'update_time' => time()
    ];
    $temp = $wechat_user->updateUserByOpenid($update_data, $openid, $uniacid);
  } else {
    $res = $wechat_user->addUser([
      'openid' => $openid,
      'uniacid' => $uniacid,
      'subscribe' => $user_info['subscribe'],
      'nickname' => $user_info['nickname'],
      'headimgurl' => $user_info['avatar'],
      'sex' => $user_info['sex'],
      'create_time' => time(),
    ]);
    
  }
}
// else {
//   // 
//   message('请在微信打开');
// }

include $this->template('index');

