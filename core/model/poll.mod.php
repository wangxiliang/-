<?php
namespace Core\Model;
defined('IN_IA') or exit('Access Denied');

class Poll extends Base {
  public $poll_table = MODULE_NAME . '_poll';

  public function addPoll($data) {
    $data['create_time'] = time();
    return pdo_insert($this->poll_table, $data);
  }

  public function getPollTotal($uniacid) {
    $tablename = tablename($this->poll_table);
    $sql = "SELECT
     SUM(poll) as poll from {$tablename} WHERE uniacid = {$uniacid} 
    ";
    $res = pdo_fetchcolumn($sql);
    return empty($res) ? 0 : $res;
  }

  public function updatePoll($enroll_id, $uniacid) {
    $table = tablename($this->poll_table);
    $time = time();
    $res = pdo_query("UPDATE
      {$table} SET poll = poll + 1, update_time = {$time}
      where enroll_id = {$enroll_id} and uniacid = {$uniacid}
    ");
    return $res;
  }

  public function updatePollByNum($enroll_id, $poll, $uniacid) {
    $table = tablename($this->poll_table);
    $time = time();
    $res = pdo_query("UPDATE
      {$table} SET poll = {$poll}, update_time = {$time}
      where enroll_id = {$enroll_id} and uniacid = {$uniacid}
    ");
    return $res;
  }


  public function getPollRank($enroll_id, $uniacid) {
    $table = tablename($this->poll_table);
    $sql = "SELECT b.rownum from
      (
      SELECT t.*, @rownum := @rownum + 1 AS rownum
      FROM (SELECT @rownum := 0) r, {$table} AS t
      ORDER BY t.poll DESC
      ) as b where b.enroll_id = {$enroll_id} and b.uniacid = {$uniacid};
    ";

    $rank = pdo_fetchcolumn($sql);
    return $rank;
  }

  public function delPollById($enroll_id, $uniacid) {
    return pdo_delete($this->poll_table, compact('enroll_id', 'uniacid'));
  }
}