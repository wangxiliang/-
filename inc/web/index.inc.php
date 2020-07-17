<?php
global $_GPC, $_W;

use Core\Model\Config;
$config = new Config();
$data = $config->getConfig($_W['uniacid']);
$url = $_W['siteroot'].'app/index.php'.'?i='.$_W['uniacid'].'&c=entry&do=index&m='.MODULE_NAME;
include $this->template('web/index');
