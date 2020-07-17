<?php
namespace Core\Model;
defined('IN_IA') or exit('Access Denied');

class Banner extends Base {
  public $tableName = MODULE_NAME . '_banner';
  // 
  public function getBannerList($page = 1, $uniacid) {
    return $this->query
    ->from($this->tableName)
    ->page($page, $this->db_config['limit'])
    ->where(compact('uniacid'))
    ->getall();

  }

  public function getBannerById($id, $uniacid) {
    return $this->query->from($this->tableName)
    ->where('id', $id)
    ->where('uniacid', $uniacid)
    ->get();
  }
  public function updateBannerById($data, $id, $uniacid) {
    $res = pdo_update($this->tableName, $data, compact('id', 'uniacid'));
    return $res;
  }

  public function getBanerTotal($uniacid) {
    return $this->query->from($this->tableName)
    ->where(compact('uniacid'))
    ->count();
  }

  public function addBanner($data) {
    $res = pdo_insert($this->tableName, $data);
    return $res;
  }

  public function delBannerById($id, $uniacid) {
    $res = pdo_delete($this->tableName, compact('id', 'uniacid'));
    return $res;
  }

  public function getBannerByType($type, $uniacid) {
    return $this->query->from($this->tableName)
    ->where(compact('type', 'uniacid'))
    ->getall();
  }
}