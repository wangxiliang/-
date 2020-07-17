<?php

namespace Core\Model;

defined('IN_IA') or exit('Access Denied');



class PollRecord extends Base {

  public $record_table = MODULE_NAME . '_poll_record';

  public $poll_table = MODULE_NAME . '_poll';

  public $user_table = MODULE_NAME . '_wechat_user';

  

  public function getPollRecordList($page = 1, $uniacid) {

    return $this->query->from($this->record_table, 'record')

    ->leftjoin($this->poll_table, 'poll')

    ->on('record.poll_id', 'poll.id')

    ->where(compact('uniacid'))

    ->select('record.*', 'poll.poll')

    ->page($page, $this->db_config['limit'])

    ->getall();

  }



  public function getPollRecordTotal($uniacid) {

    return $this->query->from($this->record_table, 'record')

    ->leftjoin($this->poll_table, 'poll')

    ->on('record.poll_id', 'poll.id')

    ->where(compact('uniacid'))

    ->count();

  }



  public function delPollRecordById($id, $uniacid) {

    return pdo_delete($this->record_table, compact('id', 'uniacid'));

  }



  public function getPollRecordCountById($poll_user_id, $poll_id, $uniacid) {

    $table = tablename($this->record_table);

    $sql = "SELECT count(1) from

     {$table} where TO_DAYS(FROM_UNIXTIME(create_time)) = TO_DAYS(NOW())

      AND poll_user_id = {$poll_user_id} 

      AND uniacid = {$uniacid} 

      AND poll_id = {$poll_id}

    ";



    $res = pdo_fetchcolumn($sql);





    return $res;

  }





  public function getPollRecordTotalById($poll_user_id, $uniacid) {

    $table = tablename($this->record_table);

    $sql = "SELECT count(1) from

    {$table} where TO_DAYS(FROM_UNIXTIME(create_time)) = TO_DAYS(NOW())

     AND poll_user_id = {$poll_user_id} 

     AND uniacid = {$uniacid} 

   ";

    $res = pdo_fetchcolumn($sql);
    return $res;

  }


  public function addPollRecord($data) {
    return pdo_insert($this->record_table, $data);
  }
}