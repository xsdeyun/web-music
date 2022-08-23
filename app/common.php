<?php
use think\facade\Config;
require_once("../extend/Epay/epay_submit.class.php");
// 应用公共文件
function send_get($url, $post = 0, $referer = 0, $cookie = 0, $header = 0, $ua = 0, $nobaody = 0)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $httpheader[] = "Accept:*/*";
    $httpheader[] = "Accept-Encoding:gzip,deflate,sdch";
    $httpheader[] = "Accept-Language:zh-CN,zh;q=0.8";
    $httpheader[] = "Connection:close";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    if ($post) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    if ($header) {
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
    }
    if ($cookie) {
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    }
    if ($referer) {
        if ($referer == 1) {
            curl_setopt($ch, CURLOPT_REFERER, 'http://music.xingyaox.com/');//Qzone_Referer
        } else {
            curl_setopt($ch, CURLOPT_REFERER, $referer);
        }
    }
    if ($ua) {
        curl_setopt($ch, CURLOPT_USERAGENT, $ua);
    } else {
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; Android 4.4.2; NoxW Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/30.0.0.0 Mobile Safari/537.36');
    }
    if ($nobaody) {
        curl_setopt($ch, CURLOPT_NOBODY, 1);
    }
    curl_setopt($ch, CURLOPT_ENCODING, "gzip");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $ret = curl_exec($ch);
    curl_close($ch);
    return $ret;
}

function GetCurl($url){
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY,true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
    curl_setopt($ch, CURLOPT_AUTOREFERER,true);
    curl_setopt($ch, CURLOPT_TIMEOUT,30);
    $rtn = curl_exec($ch);
    curl_exec($ch);
    return $rtn;
}

function daddslashes($string, $force = 0, $strip = FALSE)
{
    !defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
    if (!MAGIC_QUOTES_GPC || $force) {
        if (is_array($string)) {
            foreach ($string as $key => $val) {
                $string[$key] = daddslashes($val, $force, $strip);
            }
        } else {
            $string = addslashes($strip ? stripslashes($string) : $string);
        }
    }
    return $string;
}

function check_Hash($value, $hash)
{
    return password_verify($value, $hash);
}

function make_Hash($value)
{
    return password_hash($value, PASSWORD_DEFAULT);
}

function real_ip()
{
    $ip = $_SERVER['REMOTE_ADDR'];
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
        foreach ($matches[0] AS $xip) {
            if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                $ip = $xip;
                break;
            }
        }
    } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CF_CONNECTING_IP'])) {
        $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
    } elseif (isset($_SERVER['HTTP_X_REAL_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_X_REAL_IP'])) {
        $ip = $_SERVER['HTTP_X_REAL_IP'];
    }
    return $ip;
}

function ip_city_str($str)
{
    return str_replace(array('省', '市'), '', $str);
}

function get_ip_city($ip)
{
    $ip = empty($ip) ? request()->ip() : $ip;
    $url = 'http://whois.pconline.com.cn/ipJson.jsp?json=true&ip=';
    $city = file_get_contents($url . $ip);
    $city = mb_convert_encoding($city, "UTF-8", "GB2312");
    $city = json_decode($city, true);
    
	if(!array_key_exists('city', $city)){
        $result = '未知地址';
    }else{
        $result = $city['city'];;
    }
    return $result;
}

function get_domain()
{
    $siteurl = ($_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/';
    return $siteurl;
}
function authcode($string, $operation = '', $key = '', $expiry = 0)
{
    $ckey_length = 4;
    $key = md5($key ? $key : 'zyzs');
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? $operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length) : '';
    $cryptkey = $keya . md5($keya . $keyc);
    $key_length = strlen($cryptkey);
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
    $string_length = strlen($string);
    $result = '';
    $box = range(0, 255);
    $rndkey = array();
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }
    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ $box[($box[$a] + $box[$j]) % 256]);
    }
    if ($operation == 'DECODE') {
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc . str_replace('=', '', base64_encode($result));
    }
}

function drawings_js($money,$drawings)
{
	$drawings = $money*$drawings;
	return $drawings;
}

function getFilesize($filesize){
    if($filesize >= 1048576) {
       $filesize = round($filesize / 1048576 * 100) / 100 . 'GB';
    } elseif($filesize >= 1024) {
       $filesize = round($filesize / 1024 * 100) / 100 . 'MB';
    } else {
       $filesize = $filesize . 'KB';
    }
    return $filesize;
 }

 //$arrays 需要排序的数组,$sort_key 需要排序的键名称
function my_sort($arrays,$sort_key,$sort_order=SORT_DESC,$sort_type=SORT_NUMERIC ){
    if(is_array($arrays)){
        foreach ($arrays as $array){
            if(is_array($array)){
                $key_arrays[] = $array[$sort_key];
            }else{
                return false;
            }
        }
    }else{
        return false;
    }
    array_multisort($key_arrays,$sort_order,$sort_type,$arrays);
    return $arrays;
}

function hideStr($string, $bengin = 0, $len = 4, $type = 0, $glue = "@") {
    if (empty($string))
        return false;
    $array = array();
    if ($type == 0 || $type == 1 || $type == 4) {
        $strlen = $length = mb_strlen($string);
        while ($strlen) {
            $array[] = mb_substr($string, 0, 1, "utf8");
            $string = mb_substr($string, 1, $strlen, "utf8");
            $strlen = mb_strlen($string);
        }
    }
    if ($type == 0) {
        for ($i = $bengin; $i < ($bengin + $len); $i++) {
            if (isset($array[$i]))
                $array[$i] = "*";
        }
        $string = implode("", $array);
    } else if ($type == 1) {
        $array = array_reverse($array);
        for ($i = $bengin; $i < ($bengin + $len); $i++) {
            if (isset($array[$i]))
                $array[$i] = "*";
        }
        $string = implode("", array_reverse($array));
    } else if ($type == 2) {
        $array = explode($glue, $string);
        $array[0] = hideStr($array[0], $bengin, $len, 1);
        $string = implode($glue, $array);
    } else if ($type == 3) {
        $array = explode($glue, $string);
        $array[1] = hideStr($array[1], $bengin, $len, 0);
        $string = implode($glue, $array);
    } else if ($type == 4) {
        $left = $bengin;
        $right = $len;
        $tem = array();
        for ($i = 0; $i < ($length - $right); $i++) {
            if (isset($array[$i]))
                $tem[] = $i >= $left ? "*" : $array[$i];
        }
        $array = array_chunk(array_reverse($array), $right);
        $array = array_reverse($array[0]);
        for ($i = 0; $i < $right; $i++) {
            $tem[] = $array[$i];
        }
        $string = implode("", $tem);
    }
    return $string;
}

function whits($num) {
	return $num<10000?$num:sprintf("%.1f", $num/10000).'万';
}

function time_tran($the_time) {
    $now_time = date("Y-m-d H:i:s", time());
    $now_time = strtotime($now_time);
    $show_time = strtotime($the_time);
    $dur = $now_time - $show_time;
    if ($dur < 0) {
        return $the_time;
    } else {
        if ($dur < 60) {
            return $dur . '秒前';
        } else {
            if ($dur < 3600) {
                return floor($dur / 60) . '分钟前';
            } else {
                if ($dur < 86400) {
                    return floor($dur / 3600) . '小时前';
                } else {
                    if ($dur < 2592000) {//30天内
                        return floor($dur / 86400) . '天前';
                    } else {
						if ($dur < 31104000) {//12月内
							return floor($dur / 2592000) . '月前';
						}else{
							if ($dur < 3110400000) {//100年内
								return floor($dur / 31104000) . '年前';
							} else{
								return $the_time;
							}
						}
					}
				}
			}
		}
	}
}

function mainColor($image)
{
	$imageInfo = getimagesize($image);
	$imgType   = strtolower(substr(image_type_to_extension($imageInfo[2]), 1));
	$imageFun  = 'imagecreatefrom' . ($imgType == 'jpg' ? 'jpeg' : $imgType);
	$i         = $imageFun($image);
	$rColorNum = $gColorNum = $bColorNum = $total = 0;
	for ($x = 50; $x < imagesx($i) - 50; $x++) {
		for ($y = 50; $y < imagesy($i) - 50; $y++) {
			$rgb = imagecolorat($i, $x, $y);
			$r   = ($rgb >> 16) & 0xFF;
			$g   = ($rgb >> 8) & 0xFF;
			$b   = $rgb & 0xFF;
			$rColorNum += $r;
			$gColorNum += $g;
			$bColorNum += $b;
			$total++;
		}
	}
	return [round($rColorNum / $total), round($gColorNum / $total), round($bColorNum / $total)];
}

function is_peie_num($int)
{
    switch ($int) {
        case 1:
            $num = 1;
            break;
        case 2:
            $num = 3;
            break;
        case 3:
            $num = 5;
            break;
        case 4:
            $num = 10;
            break;
    }
    return $num;
}

function get_url_ico($url){
    $url_arr=parse_url($url);
    if(!$url_arr['scheme']){
        $url.="http://";
    }
    $url_arr=parse_url($url);
    $url=$url_arr['scheme']."://".$url_arr['host'];
    if(url_exists($url)){
        $api_url="http://g.soz.im/{$url}/cdn.ico";
        $ico=$url."/favicon.ico";
        if(remote_file_exists($ico)){
            return $ico;
        }elseif(remote_file_exists($api_url)){
            return $api_url;
        }else{
			return '/favicon.ico';
        }
    }else{
        return '/favicon.ico';
    }
}

function url_exists($url)   
{  
   $head = @get_headers($url);  
   return is_array($head) ?  true : false;  
}

function remote_file_exists($url) {
    $executeTime = ini_get('max_execution_time');
    ini_set('max_execution_time', 0);
    $headers = @get_headers($url);
    ini_set('max_execution_time', $executeTime);
    if ($headers) {
        $head = explode(' ', $headers[0]);
        if ( !empty($head[1]) && intval($head[1]) < 400) return true;
    }
    return false;
}

function Pay($orderid, $name, $price, $type, $shop, $shopid)
{
    $epay_config = [
        'partner' => Config::get('web.epay_id'),
        'key' => Config::get('web.epay_key'),
        'sign_type' => strtoupper('MD5'),
        'input_charset' => strtolower('utf-8'),
        'transport' => 'http',
        'apiurl' => Config::get('web.epay_url')
    ];
    $parameter = array(
        "pid" => trim($epay_config['partner']),
        "type" => $type,
        "notify_url" => 'http://' . $_SERVER['HTTP_HOST'] . url('Epay/' . $shop . '_Notify'), //服务器异步通知页面路径
        "return_url" => 'http://' . $_SERVER['HTTP_HOST'] . url('Epay/' . $shop . '_Return'), //页面跳转同步通知页面路径
        "out_trade_no" => $orderid,
        "name" => $name,
        "money" => $price,
        "shop" => $shop,
        "shopid" => $shopid,
        "sitename" => Config::get('web.webname')
    );
    //建立请求
    $alipaySubmit = new AlipaySubmit($epay_config);
    $html_text = $alipaySubmit->buildRequestForm($parameter, "get");
    return $html_text;
}