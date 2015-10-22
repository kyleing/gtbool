<?php

if (! function_exists('ref'))
{
    /**
     * Return the given object by reference. Useful for chaining.
     *
     * @param $obj
     * @return mixed
     */
    function &ref($obj)
    {
        return $obj;
    }
}

/**
 * custom helper functions
 */
if (!function_exists('h'))
{
    function h($string, $charlist = '', $remove_tag = true)
    {

        $string = $charlist ? trim($string, $charlist) : trim($string); // remove space

        if ($remove_tag)
        {
            $string = filter_var($string, FILTER_SANITIZE_STRING); // remove html tags
        }

        $string = filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS);

        return $string;
    }
}

if (!function_exists('image_root'))
{
    /**
     * Image Root Path
     */
    function image_root()
    {
        $default = dirname(dirname(__DIR__)) . '/uimg/public';
        $imageDir = \Config::get('image.root', $default);
        return $imageDir;
    }
}

if (!function_exists('ft'))
{
    /**
     * format publish time
     */
    function ft($timeIn)
    {
        $s = time() - $timeIn;
        return ($s < 3600) ? (($s >= 60) ? ceil($s / 60) . "分钟前" : "{$s}秒钟前") : (($s >= 3600 and $s <= 36000) ? ceil($s / 3600) . "小时前" : date("m月d日h:i", $timeIn));
    }
}

if (!function_exists('timediff'))
{
    function timediff($begin_time, $end_time, $format = '-')
    {
        $starttime = strtotime($begin_time);
        $endtime = strtotime($end_time);

        $timediff = $endtime - $starttime;

        $hours = intval($timediff / 3600);

        $remain = $timediff % 86400 % 3600;
        $mins = intval($remain / 60);

        $secs = $remain % 60;

        return $hours . $format . $mins . $format . $secs;
    }
}

if (!function_exists('url64encode'))
{
    /**
     * URL 64 encode
     */
    function url64encode($string)
    {
        $data = base64_encode($string);
        $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
        return $data;
    }
}

if (!function_exists('url64decode'))
{
    /**
     * URL 64 decode
     */
    function url64decode($string)
    {
        $data = str_replace(array('-', '_'), array('+', '/'), $string);
        $mod4 = strlen($data) % 4;
        if ($mod4)
        {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }
}

if (!function_exists('authcode'))
{
    /**
     * @param string $string 原文或者密文
     * @param string $operation 操作(ENCODE | DECODE), 默认为 DECODE
     * @param string $key 密钥
     * @param int $expiry 密文有效期, 加密时候有效， 单位 秒，0 为永久有效
     * @return string 处理后的 原文或者 经过 base64_encode 处理后的密文
     *
     * @example
     *
     *  $a = authcode('abc', 'ENCODE', 'key');
     *  $b = authcode($a, 'DECODE', 'key');  // $b(abc)
     *
     *  $a = authcode('abc', 'ENCODE', 'key', 3600);
     *  $b = authcode('abc', 'DECODE', 'key'); // 在一个小时内，$b(abc)，否则 $b 为空
     */
    function authcode($string, $operation = 'DECODE', $key = '', $expiry = 3600)
    {
        $ckey_length = 4;
        // 随机密钥长度 取值 0-32;
        // 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
        // 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
        // 当此值为 0 时，则不产生随机密钥

        $key = md5($key ? : Config::get('app.key'));
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';

        $cryptkey = $keya . md5($keya . $keyc);
        $key_length = strlen($cryptkey);

        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
        $string_length = strlen($string);

        $result = '';
        $box = range(0, 255);

        $rndkey = array();
        for ($i = 0; $i <= 255; $i++)
        {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }

        for ($j = $i = 0; $i < 256; $i++)
        {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }

        for ($a = $j = $i = 0; $i < $string_length; $i++)
        {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }

        if ($operation == 'DECODE')
        {
            if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16))
            {
                return substr($result, 26);
            }
            else
            {
                return '';
            }
        }
        else
        {
            return $keyc . str_replace('=', '', base64_encode($result));
        }
    }
}

if (!function_exists('array_key_map'))
{
    /**
     * Change key according by the $mapper
     *
     * @param  array $array
     * @param  array $keymap
     * @return array
     */
    function array_key_map($array, $keymap)
    {
        $keys = array_keys($keymap);
        $arr = array_only($array, $keys);
        $array = array_except($array, $keys);
        foreach ($arr as $k => $v)
        {
            $array[$keymap[$k]] = $v;
        }
        return $array;
    }
}

/**
 * Convert xml object to array
 */
if (!function_exists('xmlToArray')){
    function xmlToArray($xmlObj)
    {
        $output = [];
        foreach ((array)$xmlObj as $index => $node)
        {
            $output[$index] = (is_object($node)) ? xmlToArray($node) : $node;
        }
        return $output;
    }
}

if (!function_exists('gen_cache_key'))
{
    /**
     * 生成cache用的key
     * @param string|object $clazz
     * @param string $method
     * @param array $param 参数列表
     * @return string
     */
    function gen_cache_key($clazz, $method, $param = [])
    {
        return class_basename($clazz) . $method . (empty($param) ? '' : '?' . http_build_query($param));
    }
}

if (!function_exists('erp_date_format'))
{
    /**
     * ERP 日期格式化
     */
    function erp_date_format($erp_date)
    {
        return date("Y-m-d H:i:s", strtotime($erp_date));
    }
}

if (!function_exists('image_url'))
{
    function image_url($uri, $scale = false)
    {
        //todo read image baseurl from config
        $baseurl = 'http://uimg.uzise.com/product/';
        return $scale ? $baseurl . $scale . '/' . $uri : $baseurl . $uri;
    }
}

if (!function_exists('checkMobile'))
{
    /**
     * 验证手机格式
     */
    function checkMobile($mobilephone)
    {
        # if (preg_match("/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$/", $mobilephone))
        if (preg_match("/^1[0-9]{10}$/", $mobilephone))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

if (!function_exists('array_sort_by'))
{
    function array_sort_by($arr, $field, $desc = true)
    {
        return array_sort($arr, function ($item) use ($field, $desc)
        {
            return $item[$field] * ($desc ? 1 : -1);
        });
    }
}


/**
 * @desc  数组排序
 * @param 排序的参照列的键
 * @param 需要排序的数组
 * @return array
 **/

if (!function_exists('array_sort_by_column'))
{
    function array_sort_by_column($key, $arr, $sort = 'desc')
    {

        $keys = [];

        foreach ($arr as $a)
        {
            $keys[] = $a[$key];
        }
        $sort = $sort == 'asc' ? SORT_ASC : SORT_DESC;

        array_multisort($keys, $sort, $arr);

        return $arr;

    }
}

if (!function_exists('array_column'))
{
    /**
     * Flatten a multi-dimensional array into a single level.
     *
     * @param array $array
     * @param string $key
     * @return array
     */
    function array_column($array, $key = '')
    {
        $return = array();

        array_walk_recursive($array, function ($v, $k, $ukey) use (&$return)
        {
            if (empty($ukey))
            {
                $return[] = $v;
            }
            else
            {
                if ($ukey == $k)
                {
                    $return[] = $v;
                }
            }
        }, $key);
        return $return;
    }
}

if (!function_exists('m_encrypt'))
{
    function m_encrypt($str, $key = 'lumbini')
    {
        $crypt = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $str, MCRYPT_MODE_CBC, md5(md5($key))));
        $crypt = base64_encode($crypt);
        $crypt = str_replace(array('+', '/', '='), array('-', '_', ''), $crypt);
        return trim($crypt);
    }
}

if (!function_exists('m_decrypt'))
{
    function m_decrypt($str, $key = 'lumbini')
    {
        $data = str_replace(array('-', '_'), array('+', '/'), $str);
        $mod4 = strlen($data) % 4;
        if ($mod4)
        {
            $data .= substr('====', $mod4);
        }
        $data = base64_decode($data);
        return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($data), MCRYPT_MODE_CBC, md5(md5($key))));
    }
}

if(!function_exists('http_post_data'))
{
    function http_post_data($url, $data_string) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Content-Length: ' . strlen($data_string))
        );
        ob_start();
        curl_exec($ch);
        $return_content = ob_get_contents();
        ob_end_clean();

        $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return array($return_code, $return_content);
    }
}

if(!function_exists('http_get_data'))
{
    function http_get_data($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
        ));
        ob_start();
        curl_exec($ch);
        $return_content = ob_get_contents();
        ob_end_clean();

        $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return array($return_code, $return_content);
    }
}

//--------------------- link macro
if (!function_exists('link_product'))
{
    function link_product($prodId, $prefix = '')
    {
        return $prefix . '/goods-' . array_get($prodId, 'product_id', $prodId) . '.html';
    }
}

if (!function_exists('thumb_url'))
{
    function thumb_url($url, $size, $type = 'product')
    {
        $array = explode('/' . $type . '/', $url);
        if (count($array) == 2)
        {
            //$thumb = $array[0] . '/' . $type . '/' . $size . '/' . array_get($array, 1, '');
			$thumb = \Config::get('image.domain', $array[0]) . '/' . $type . '/' . $size . '/' . array_get($array, 1, '');
        }
        else
        {
            if(empty($url))
            {
                return '\assets\pc\images\no-pid-img.png';
            }
            
            return $url;
        }
        return $thumb;
    }
}

if (!function_exists('array_weight'))
{
    function array_weight($array, $field)
    {
        $weight = 999999999;
        $w = array_get($array, $field, $weight);
        $weight = min($w, $weight);
        foreach ($array as $v)
        {
            if (is_array($v))
            {
                $w = array_weight($v, $field);
                $weight = min($w, $weight);
            }
        }
        return $weight;
    }
}

// -------------------- rsa helper function...
/* *
 * 支付宝接口RSA函数
 * 详细：RSA签名、验签、解密
 * 版本：3.3
 * 日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。
 */

if(function_exists('rsaSign')){
    /**
     * RSA签名
     * @param string $data 待签名数据
     * @param string $private_key_path 商户私钥文件路径
     * return 签名结果
     * @return string
     */
    function rsaSign($data, $private_key_path) {
        $priKey = file_get_contents($private_key_path);
        $res = openssl_get_privatekey($priKey);
        openssl_sign($data, $sign, $res);
        openssl_free_key($res);
        //base64编码
        $sign = base64_encode($sign);
        return $sign;
    }
}
if(function_exists('rsaVerify')){
    /**
     * RSA验签
     * @param string $data 待签名数据
     * @param string $ali_public_key_path 支付宝的公钥文件路径
     * @param string $sign 要校对的的签名结果
     * return 验证结果
     * @return bool
     */
    function rsaVerify($data, $ali_public_key_path, $sign)  {
        $pubKey = file_get_contents($ali_public_key_path);
        $res = openssl_get_publickey($pubKey);
        $result = (bool)openssl_verify($data, base64_decode($sign), $res);
        openssl_free_key($res);
        return $result;
    }
}

if(function_exists('rsaDecrypt')){
    /**
     * RSA解密
     * @param string $content 需要解密的内容，密文
     * @param string $private_key_path 商户私钥文件路径
     * return 解密后内容，明文
     * @return string
     */
    function rsaDecrypt($content, $private_key_path) {
        $priKey = file_get_contents($private_key_path);
        $res = openssl_get_privatekey($priKey);
        //用base64将内容还原成二进制
        $content = base64_decode($content);
        //把需要解密的内容，按128位拆开解密
        $result  = '';
        for($i = 0; $i < strlen($content)/128; $i++  ) {
            $data = substr($content, $i * 128, 128);
            openssl_private_decrypt($data, $decrypt, $res);
            $result .= $decrypt;
        }
        openssl_free_key($res);
        return $result;
    }
}

// -------------------- laravel base helper function ------------------
if (!function_exists('C'))
{
    /**
     * 获得真正controller名称
     * @param string $controller controller uri
     */
    function C($controller)
    {
        //todo
    }
}

if (!function_exists('D'))
{
    /**
     * 获得数据库的操作实际例
     * @param $table
     * @param $pkey
     * @return \App\Http\Models\Common\DBOperator
     */
    function D($table, $pkey = 'id')
    {
        return App\Http\Models\Common\DBOperator::table($table, $pkey);
    }
}

if (!function_exists('tag'))
{
    function tag($name, &$params)
    {
        Services\Behavior\Behavior::tag($name, $params);
    }
}


if (!function_exists('isConfigHide'))
{
    /**
     * 隐藏后台菜单判断函数
     */
    function isConfigHide()
    {
        return (boolean)\Config::get('app.hide');
    }
}

if (!function_exists('mobile'))
{
    /**
     * @param $mobile 没有替换之前的号码
     * @return 退换后的手机号
     */
    function mobile($mobile)
    {
        if (starts_with($mobile, '.') && ends_with($mobile, '.'))
        {
            try
            {
                $mob_tb = 'var_shipping_mobile';
                $mock = \App\Http\Models\Common\DBOperator::table($mob_tb)->findByOne(['used' => $mobile]);
                if ($mock)
                {
                    return $mock['mobile'];
                }
                else
                {
                    $mock = \App\Http\Models\Common\DBOperator::table($mob_tb)->findByOne(['used' => 0]);
                    if ($mock)
                    {
                        $mock['used'] = substr($mobile, 1, strlen($mobile) - 2);
                        \App\Http\Models\Common\DBOperator::table($mob_tb, 'mobile')->updateById($mock);
                        return $mock['mobile'];
                    }
                }
            } catch (\Exception $e)
            {
            }
            return substr($mobile, 1, strlen($mobile) - 2);
        }
        else
        {
            return $mobile;
        }
    }
}


if (!function_exists('getFormatEndDate'))
{
    /**
     * 日期加23:59:59
     */
    function getFormatEndDate($date)
    {
        return date('Y-m-d', strtotime($date)) . ' 23:59:59';
    }
}


if (!function_exists('makeOrderSn'))
{
    /**
     * @desc 业务号生成函数
     */
    function makeOrderSn()
    {
        $prefix = date('ymd', time());

        $rand = '';

        for($i=0; $i< 8; $i++)
        {
            $rand .= mt_rand(0,9);
        }

        return $prefix . $rand;
    }
}

if (!function_exists('makeShipSn'))
{
    /**
     * @desc 物流单号生成函数
     */
    function makeShipSn()
    {
        $abc =['A','B','C','D','E','F','G','H','I','J'];
        $prefix = date('ymd', time());

        $rand = '';

        for($i=0; $i< 4; $i++)
        {
            $seed = mt_rand(0,9);
            $rand .= $seed.$abc[$seed];
        }

        return $prefix . $rand;
    }
}


if(!function_exists('responseJson'))
{
    /**
     * @desc 返回json信息
     */
    function responseJson($status = false,$message='')
    {
        $message = !empty($message) ? :((bool)$status ? '操作成功' : '操作失败');
        $state = $status ? 'success' : 'error';
         echo json_encode(['status'=>$state,'message'=>$message]);
        return ;
    }
}

if(!function_exists('geo_rad'))
{
    function geo_rad($d)
    {
        return $d * 3.1415926535898 / 180.0;
    }
}

if(!function_exists('geo_distance'))
{
    function geo_distance($lat1, $lng1, $lat2, $lng2)
    {
        $EARTH_RADIUS = 6378.137;
        $radLat1 = geo_rad($lat1);
        //echo $radLat1;
       $radLat2 = geo_rad($lat2);
       $a = $radLat1 - $radLat2;
       $b = geo_rad($lng1) - geo_rad($lng2);
       $s = 2 * asin(sqrt(pow(sin($a/2),2) +
        cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)));
       $s = $s *$EARTH_RADIUS;
       $s = round($s * 10000) / 10000;
       return $s;
    }
}


