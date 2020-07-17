<?php
defined('IN_IA') or exit('Access Denied');

if (!function_exists('dump')) {
    function dump()
    {
        $args = func_get_args();
        foreach ($args as $val) {
            echo '<pre style="color: red">';
            var_dump($val);
            echo '</pre>';
        }
    }
}

if (!function_exists('order_sn')) {
    function order_sn($uid)
    {
        global $_W;
        $uid = $uid ? $uid : $_W['uniacid'];
        $str = date('Ymd').substr(implode(null, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
        $oid = $uid ? str_pad($uid, 5, '0', STR_PAD_LEFT) : rand(0, 100);
        return $str.$oid;
    }
}

if (!function_exists('get_type_class_for_api')) {
    function get_type_class_for_api($class)
    {
        $type = strtolower($class);
        if (preg_match("/web/", $type)) {
            return array(
                'web',
                strtolower(substr($class, 3))
            );
        } elseif (preg_match("/mobile/", $type)) {
            return array(
                'mobile',
                strtolower(substr($class, 6))
            );
        } elseif (preg_match("/page/", $type)) {
            return array(
                'page',
                strtolower(substr($class, 4))
            );
        }
    }
}

if (!function_exists('create_qrcode')) {
    function create_qrcode($content)
    {
        load()->library('qrcode');
        $errorCorrectionLevel = "L";
        $size = 13;
        ob_start();
        QRcode::png($content, false, $errorCorrectionLevel, $size, 0);
        $code = base64_encode(ob_get_contents());
        header('Content-type: application/json');
        ob_end_clean();
        if (empty($code)) {
            return '';
        } else {
            return 'data:image/png;base64,'.$code;
        }
    }
}

if (!function_exists('get_week_date_list')) {
    function get_week_date_list($time = '', $format = 'Y-m-d')
    {
        $time = $time != '' ? $time : time();
        //组合数据
        $date = [];
        for ($i = 1; $i <= 5; $i++) {
            $date[$i - 1] = date($format, strtotime('+'.$i - 5 .' days', $time));
        }
        return $date;
    }
}

if (!function_exists('get_current_ip')) {
    function get_current_ip()
    {
        $user_IP = ($_SERVER["HTTP_VIA"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"];
        $user_IP = ($user_IP) ? $user_IP : $_SERVER["REMOTE_ADDR"];
        return $user_IP;
    }

}


