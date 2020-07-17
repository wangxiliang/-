<?php
namespace Core\Model;
// 模型基类
class Base extends \We7Table {
  public $db_config = [];
  public function __construct() {
    parent::__construct();
    include IA_ROOT.'/addons/'.MODULE_NAME.'/core/config.php';
    global $_W;
    $this->db_config = $config['db_config'];

  }
}