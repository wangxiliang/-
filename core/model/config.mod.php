<?php
namespace Core\Model;
defined('IN_IA') or exit('Access Denied');

class Config extends Base {
  public $config_table = MODULE_NAME . '_config';
  
  public function getConfig($uniacid) {
    $data = $this->query->from($this->config_table, 'config')
    ->where('uniacid', $uniacid)->get();

    // 处理时间戳
    if(!empty($data)) {
      $data['poll_start_time'] = date('Y-m-d H:i:s', $data['poll_start_time']);
      $data['poll_end_time'] = date('Y-m-d H:i:s', $data['poll_end_time']);
    }
    return $data;
  }

  public function updateConfig($data, $uniacid) {
    $data['update_time'] = time();
    return pdo_update($this->config_table, $data, compact('uniacid'));
  }

  public function addConfig($data) {
    $data['create_time'] = time();
    return pdo_insert($this->config_table, $data);
  }

  

}