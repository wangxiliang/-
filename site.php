<?php
defined('IN_IA') or exit('Access Denied');
defined('MODULE_NAME') or define('MODULE_NAME', 'zyun_vote');
require_once IA_ROOT.'/addons/'.MODULE_NAME.'/vendor/autoload.php';


use Core\Model\Banner;
use Core\Model\Enroll;
use Core\Model\Poll;
use Core\Model\PollRecord;
use Core\Model\Config;
use Core\Model\WechatUser;
use Core\Common\Utils;
use Core\Common\Oauth;

class Zyun_voteModuleSite extends WeModuleSite
{

  public $config = [];

  public $modelEnroll;
  public $modelBanner;
  public $modelPoll;
  public $modelConfig;
  public $modelPollRecord;
  public $modelUser;
  public $uniacid;

  public function __construct()
  {
    include IA_ROOT.'/addons/'.MODULE_NAME.'/core/config.php';
    global $_W;
    $this->config = $config;
    $this->uniacid = $_W['uniacid'];
    $this->modelBanner = new Banner();
    $this->modelEnroll = new Enroll();
    $this->modelPoll = new Poll();
    $this->modelConfig = new Config();
    $this->modelPollRecord = new PollRecord();
    $this->modelUser = new WechatUser();
  }

  public function json($data = []) {
    
    exit(json_encode(array(
      'errno' => $data['errno'] ? $data['errno'] : 0,
      'message' => $data['message'] ? $data['message'] : 'success',
      'data' => $data['data'] ? $data['data'] : [],
    )));
  }

  public function json_err($message = '服务器异常') {
    http_response_code(400);
    $this->json([
      'errno' => $this->config['json_config']['errno_fail'],
      'message' => $message
    ]);
  }

  public function json_suc($message = 'success', $data = []) {
    $this->json([
      'errno' => $this->config['json_config']['errno_suc'],
      'message' => $message,
      'data' => $data
    ]);
  }
  
  public function doMobilegetBanner() {
    header('Access-Control-Allow-Origin: http://localhost:8080');
    global $_GPC, $_W;
    $type = $_GPC['type'];
    
    $list = $this->modelBanner->getBannerByType($type, $this->uniacid);

    $this->json_suc('', $list);
  }

  public function doMobilegetCount() {
    header('Access-Control-Allow-Origin: http://localhost:8080');
    global $_GPC, $_W;
    $enrollTotal = $this->modelEnroll->getEnrollTotal($this->uniacid);
    $pollTotal = $this->modelPoll->getPollTotal($this->uniacid);
    $this->json_suc('', compact('enrollTotal', 'pollTotal'));
  }

  public function doMobilegetEnrollList() {
    header('Access-Control-Allow-Origin: http://localhost:8080');
    global $_GPC, $_W;
    $res = $this->modelEnroll->getEnrollList($_GPC['page'], $this->uniacid);
    $this->json_suc('', $res);
  }

  public function doMobilegetEnrollByName() {
    header('Access-Control-Allow-Origin: http://localhost:8080');
    global $_GPC, $_W;
    if(empty($_GPC['name'])) return $this->json_err('请输入选手名称');
    
    $res = $this->modelEnroll->getEnrollByName($_GPC['name'], $this->uniacid);
    $this->json_suc('', $res);
  }

  public function doMobilegetEnrollById() {
    header('Access-Control-Allow-Origin: http://localhost:8080');
    global $_GPC, $_W;
    $res = $this->modelEnroll->getEnrollById($_GPC['id'], $this->uniacid);
    $this->json_suc('', $res);
  }

  public function doMobilePoll() {
    header('Access-Control-Allow-Origin: http://localhost:8080');
    global $_GPC, $_W;
    if(!$_GPC['enroll_id'] || !$_GPC['openid'] || !$_GPC['poll_id'] || !$_GPC['be_openid']) return $this->json_err('非法请求');

    // 判断是否开始
    $config = $this->modelConfig->getConfig($this->uniacid);

    if(empty($config['poll_start_time']) || (strtotime($config['poll_start_time']) - time()) > 0) {
      return $this->json_err('活动还未开始');
    }

    if((strtotime($config['poll_end_time']) - time()) < 0) {
      return $this->json_err('活动已结束');
    }

    // 可投总票数
    $pollTotal = $config['poll_total'];
    // 用户单次投票数
    $pollNum = $config['poll_num'];
    
    // 投票人信息
    $user = $this->modelUser->getUserByOpenid($_GPC['openid'], $this->uniacid);
    // 被投票人信息
    $be_user_enroll = $this->modelEnroll->getEnrollByOpenid($_GPC['be_openid'], $this->uniacid);
    $be_user = $this->modelUser->getUserByOpenid($_GPC['be_openid'], $this->uniacid);
    $pollCount = $this->modelPollRecord->getPollRecordCountById($user['id'], $_GPC['poll_id'],$this->uniacid);
    
    // 单次投票数是否超出
    if($pollCount > $pollNum) return $this->json_err('已超出单次投票数');

    // 总投票数是否超出
    $pollCountMax = $this->modelPollRecord->getPollRecordTotalById($user['id'], $this->uniacid);

    if($pollCountMax >= $pollTotal) return $this->json_err('您的票数已用完');

    $res = $this->modelPoll->updatePoll($_GPC['enroll_id'], $this->uniacid);
    
    if(empty($res)) return $this->json_err();

    // 添加投票记录
    $record_res = $this->modelPollRecord->addPollRecord([
      'poll_id' => $_GPC['poll_id'],
      'poll_user_id' => $user['id'],
      'user_id' => $be_user['id'],
      'username' => $be_user_enroll['name'],
      'title' => $_GPC['title'],
      'poll_num' => 1,
      'uniacid' => $this->uniacid,
      'create_time' => time()
    ]);

    if(empty($record_res)) return $this->json_err();
    
    $this->json_suc('投票成功');
  }
  
  public function doMobilegetRanks() {
    header('Access-Control-Allow-Origin: http://localhost:8080');
    global $_GPC, $_W;
    $res = $this->modelEnroll->getEnrollList($_GPC['page'], $this->uniacid, ['poll.poll' => 'DESC']);
    $this->json_suc('', $res);
  }
  public function doMobilegetConfig() {
    header('Access-Control-Allow-Origin: http://localhost:8080');
    global $_GPC, $_W;
    $res = $this->modelConfig->getConfig($this->uniacid);
    $this->json_suc('', $res);
  }

  public function doMobileaddEnroll() {
    header('Access-Control-Allow-Origin: http://localhost:8080');
    global $_GPC, $_W;

    // 获取配置 判断是否关闭线上报名
    $config = $this->modelConfig->getConfig($this->uniacid);

    if($config['enroll_status'] != 1) return $this->json_err('管理员已关闭线上报名');
    
    $type = $_GPC['type'];
    $name = $_GPC['name'];
    $phone = $_GPC['phone'];
    $sex = $_GPC['sex'];
    $title = $_GPC['title'];
    $avatar = $_GPC['avatar'];
    $openid = $_GPC['openid'];
    $uniacid = $this->uniacid;
    $sub = htmlspecialchars_decode($_GPC['sub']);

    if(!$openid) return $this->json_err();

    
    $enrollData = $this->modelEnroll->getEnrollByOpenid($openid, $this->uniacid);
    
    // 测试暂时关闭
    // if(!empty($enrollData)) return $this->json_err('该用户已报名');

    if(!$name) return $this->json_err('姓名不能为空');

    if(!$title) return $this->json_err('作品标题不能为空');

    if($type != $config['poll_type']) return $this->json_err('请刷新页面重新提交');

    $fileType = $type == 1 ? 'image' : 'video';
    $src = Utils::upload($_FILES['file'], $fileType);
    if(!$src) return $this->json_err('文件上传失败，服务器异常');

    if(!empty($_FILES['video_img'])) {
      $video_img = Utils::upload($_FILES['video_img']);
      if(!$video_img) return $this->json_err('文件上传失败，服务器异常2');
    }else {
      $video_img = '';
    }
    
    $data = [
      'enroll' => compact('name', 'phone', 'sex', 'title',  
      'sub', 'uniacid', 'openid', 'avatar'),
      'work' => compact('type', 'src', 'video_img', 'uniacid')
    ];


    $res = $this->modelEnroll->addEnroll($data);

    if(empty($res)) return $this->json_err();
    
    $this->json_suc();
  
  }

  // 
  public function doMobilegetWechat() {
    header('Access-Control-Allow-Origin: http://localhost:8080');
    global $_GPC, $_W;
    $user_info = mc_oauth_userinfo();
    $userInfo =  $this->modelUser->getUserByOpenid($user_info['openid'], $this->uniacid);
    $this->json_suc('', $userInfo);
  }

  
}