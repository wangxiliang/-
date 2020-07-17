<?php
namespace Core\Model;
defined('IN_IA') or exit('Access Denied');

class Works extends Base {
  public $work_table = MODULE_NAME . '_works';

  public function addWork($data) {
    $data['create_time'] = time();
    return pdo_insert($this->work_table, $data);
  }

  public function updateWorkById($data, $enroll_id, $uniacid) {
    return pdo_update($this->work_table, $data, compact('enroll_id', 'uniacid'));
  }

  public function delWorkById($enroll_id, $uniacid) {
    return pdo_delete($this->work_table, compact('enroll_id', 'uniacid'));
  }
}