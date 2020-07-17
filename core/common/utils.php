<?php
namespace Core\Common;
defined('IN_IA') or exit('Access Denied');

class Utils {
  public static function checkMobile($phone) {
    if(preg_match("/^1[34578]\d{9}$/", $phone)) {
      return true;
    }

    return false;
  }
  public static function upload($file, $type = 'image') {
    global $_W;
    load()->func('file'); //调用上传函数
    $res = file_upload($file, $type);

    if($res['success']) return $_W['attachurl'] . $res['path'];
   
    return false;
  }

  
}