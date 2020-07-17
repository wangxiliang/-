<?php

namespace Core\Model;

defined('IN_IA') or exit('Access Denied');



class Enroll extends Base {

  public $enroll_table = MODULE_NAME . '_enroll';

  public $work_table = MODULE_NAME . '_works';

  public $poll_table = MODULE_NAME . '_poll';

  public function getEnrollList($page = 1, $uniacid, $order = ['enroll.id' => 'ASC']) {

    return $this->query->from($this->enroll_table, 'enroll')

    ->leftjoin($this->work_table, 'work')

    ->on('enroll.id', 'work.enroll_id')

    ->leftjoin($this->poll_table, 'poll')

    ->on('enroll.id', 'poll.enroll_id')

    ->where('enroll.uniacid', $uniacid)

    ->select('enroll.*', 'work.src', 'work.video_img', 'work.type', 'poll.poll', 'poll.id as poll_id')

    ->page($page, $this->db_config['limit'])

    ->orderby(array_keys($order)[0], array_values($order)[0])

    ->getall();

  }

  

  public function getEnrollTotal($uniacid) {

    return $this->query->from($this->enroll_table, 'enroll')

    ->leftjoin($this->work_table, 'work')

    ->on('enroll.id', 'work.enroll_id')

    ->where(compact('uniacid'))

    ->count();

  }



  public function getEnrollById($id, $uniacid) {

    $data = $this->query->from($this->enroll_table, 'enroll')

    ->leftjoin($this->work_table, 'work')

    ->on('enroll.id', 'work.enroll_id')

    ->leftjoin($this->poll_table, 'poll')

    ->on('enroll.id', 'poll.enroll_id')

    ->where('enroll.id', $id)

    ->where('enroll.uniacid', $uniacid)

    ->select('enroll.*', 'work.src', 'work.video_img', 'work.type', 'poll.poll', 'poll.id as poll_id')

    ->get();

    $rank = (new Poll)->getPollRank($id, $uniacid);

    $data['rank'] = $rank;

    return $data;

  }

 

  



  public function addEnroll($data) {

    $data['enroll']['create_time'] = time();

    $res = pdo_insert($this->enroll_table, $data['enroll']);

    if(!empty($res)) {

      

      $enroll_id = pdo_insertid();



      (new Poll)->addPoll([

        'enroll_id' => $enroll_id,

        'openid' => $data['enroll']['openid'],

        'poll' => $data['poll'],

        'uniacid' => $data['enroll']['uniacid'],

        'create_time' => time()

      ]);



      $workData = $data['work'];

      $workData['enroll_id'] = $enroll_id;

      return (new Works)->addWork($workData);

    }



    return $res;

  }



  public function updateEnrollById($data, $id, $uniacid) {

    $data['enroll']['update_time'] = time();

    $res = pdo_update($this->enroll_table, $data['enroll'], compact('id', 'uniacid'));
    
    if(!empty($res)) {

      $data['work']['update_time'] = time();

      $res2 = (new Poll)->updatePollByNum($id, $data['poll'], $uniacid);

      $res = (new Works)->updateWorkById($data['work'], $id, $uniacid);
      return $res;
    }

    return $res;

  }



  public function getEnrollByName($name, $uniacid) {

    return $this->query->from($this->enroll_table, 'enroll')

    ->leftjoin($this->work_table, 'work')

    ->on('enroll.id', 'work.enroll_id')

    ->leftjoin($this->poll_table, 'poll')

    ->on('enroll.id', 'poll.enroll_id')

    ->where(['enroll.uniacid' => $uniacid, 'enroll.name' => $name])

    ->select('enroll.*', 'work.src', 'work.video_img', 'work.type', 'poll.poll')

    ->getall();

  }



  public function delEnrollById($id, $uniacid) {

    $res = pdo_delete($this->enroll_table, compact('id', 'uniacid'));

    if(!empty($res)) {

      (new Poll)->delPollById($id, $uniacid);
      return (new Works)->delWorkById($id, $uniacid);

    }

    return $res;

  }

  public function getEnrollByOpenid($openid, $uniacid) {
    return $this->query->from($this->enroll_table, 'enroll')

    ->leftjoin($this->work_table, 'work')

    ->on('enroll.id', 'work.enroll_id')

    ->leftjoin($this->poll_table, 'poll')

    ->on('enroll.id', 'poll.enroll_id')

    ->where(['enroll.uniacid' => $uniacid, 'enroll.openid' => $openid])

    ->select('enroll.*', 'work.src', 'work.video_img', 'work.type', 'poll.poll')

    ->get();
  }

}