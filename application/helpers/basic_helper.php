<?php
/**
 * Hy - 扩展基础函数库
 *
 * 系统扩展，可独立于系统运行的函数
 *
 * Copyright (c) 2013 YinHailin All rights reserved.
 * @Author: YinHailin
 * @Authorize: Boren Network
 * @Created by YinHailin at 2013-11-20
 */

/**
 * 深度转义函数
 * @param mixed $mix 要进行转义的字符串或者数组
 * @return mixed
 */
function deep_addslashes($mix) {
	if (get_magic_quotes_gpc()) {
		return $mix;
	} else {
		if (gettype($mix)=="array") {
			foreach($mix as $key=>$value) {
				if (gettype($value)=="array") {
					$mix[$key] = deep_addslashes($value);
				} else {
					$mix[$key]=addslashes($value);
				}
			}
			return $mix;
		} else {
			return addslashes($mix);
		}
	}
}

/**
 * 深度反转义函数
 * @param mixed $mix 要进行转义的字符串或者数组
 * @return mixed
 */
function deep_stripslashes($mix) {
	if (gettype($mix)=="array") {
		foreach($mix as $key=>$value) {
			if (gettype($value)=="array") {
				$mix[$key] = deep_stripslashes($value);
			} else {
				$mix[$key]=stripslashes($value);
			}
		}
		return $mix;
	} else {
		return stripslashes($mix);
	}
}

/**
 * 深度转义预定义字符函数
 * @param mixed $mix 要进行转义的字符串或者数组
 * @param integer $quotestyle
 * @return mixed | string
 */
function deep_htmlspecialchars($mix, $quotestyle = ENT_QUOTES) {
	if (get_magic_quotes_gpc()) {
		$mix = deep_stripslashes($mix);
	}
	if (gettype($mix) == 'array') {
		foreach ($mix as $key=>$value) {
			if (gettype($value) == 'array') {
				$mix[$key] = deep_htmlspecialchars($value, $quotestyle);
			} else {
				$value = htmlspecialchars($value, $quotestyle);
				$value = str_replace(' ', '&nbsp;', $value);
				$mix[$key] = $value;
			}
		}
		return $mix;
	} else {
		$mix = htmlspecialchars($mix, $quotestyle);
		$mix = str_replace(' ', '&nbsp;', $mix);
		return $mix;
	}
}

/**
 * 深度反转义预定义字符函数
 * @param mixed $mix 要进行转义的字符串或者数组
 * @param integer $quotestyle
 * @return mixed
 */
function deep_htmlspecialchars_decode($mix, $quotestyle = ENT_QUOTES) {
	if (gettype($mix) == 'array') {
		foreach ($mix as $key=>$value) {
			if (gettype($value) == 'array') {
				$mix[$key] = deep_htmlspecialchars_decode($value, $quotestyle);
			} else {
				$value = str_replace('&nbsp;', ' ', $value);
				$value = htmlspecialchars_decode($value, $quotestyle);
				$mix[$key] = $value;
			}
		}
		return $mix;
	} else {
		$mix = str_replace('&nbsp;', ' ', $mix);
		$mix = htmlspecialchars_decode($mix, $quotestyle);
		return $mix;
	}
}

/**
 * 格式化数字至一定的范围
 * @param integer $number 源数据
 * @param integer $min 范围最小值，默认为0
 * @param integer $max 范围最大值，默认为255
 * @return integer
 */
function get_between($number, $min = 0, $max = 255) {
	$number = vsprintf('%d', $number);
	if ($number < $min) $number = $min;
	if ($number > $max) $number = $max;
	return $number;
}

/**
 * 闭合不完整的html标签
 * @param string $html 文本内容
 * @return string
 */
function close_tags($html) {
    // 不需要补全的标签
    $arr_single_tags = array('meta', 'img', 'br', 'link', 'area');
    // 匹配开始标签
    preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
    $openedtags = $result[1];
    // 匹配关闭标签
    preg_match_all('#</([a-z]+)>#iU', $html, $result);
    $closedtags = $result[1];
    // 计算关闭开启标签数量，如果相同就返回html数据
    $len_opened = count($openedtags);
    if (count($closedtags) == $len_opened) {
        return $html;
    }
    // 把排序数组，将最后一个开启的标签放在最前面
    $openedtags = array_reverse($openedtags);
    // 遍历开启标签数组
    for ($i = 0; $i < $len_opened; $i++) {
        // 如果需要补全的标签
        if (!in_array($openedtags[$i], $arr_single_tags)) {
            // 如果这个标签不在关闭的标签中
            if (!in_array($openedtags[$i], $closedtags)) {
                    // 直接补全闭合标签
                    $html .= '</' . $openedtags[$i] . '>';
            } else {
                unset($closedtags[array_search($openedtags[$i], $closedtags)]);
            }
        }
    }
    return $html;
}

/**
 * 字符串截取，支持中文和其他编码
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * @return string
 */
function msubstr($str, $start=0, $length, $suffix=true, $charset="utf-8") {
    if(function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    elseif(function_exists('iconv_substr')) {
        $slice = iconv_substr($str,$start,$length,$charset);
        if(false === $slice) {
            $slice = '';
        }
    }else{
        $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("",array_slice($match[0], $start, $length));
    }
	switch (strtolower($charset)) {
		case 'utf-8' :
			if (strlen($str) > $length*3) {
				return $suffix ? $slice.'...' : $slice;
			} else {
				return $slice;
			}
			break;
		default :
			if (strlen($str) > $length) {
				return $suffix ? $slice.'...' : $slice;
			} else {
				return $slice;
			}
	}
}

/**
 * 字符串截取，支持中文UTF-8编码[布局用字符串截取]
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $suffix 截断显示字符
 * @return string
 */
function lsubstr($str, $start=0, $length, $suffix=true) {
        $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re['utf-8'], $str, $match);
		$i = 0;
		foreach ($match[0] as $key => $value) {
			if (preg_match('/[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}]/', $value)) {
				$i = $i + 2;
			} else {
				$i++;
			}
			if ($i > $length) {
				$length = $key;
				break;
			} elseif ($i == $length) {
				$length = $key +1;
				break;
			}
		}
        $slice = join("",array_slice($match[0], $start, $length));
		if (count($match[0]) > $length) {
			return $suffix ? $slice.'...' : $slice;
		} else {
			return $slice;
		}
}

/**
 * 使用正则验证数据
 * @param string $value 要验证的数据
 * @param string $rule 验证规则
 * @return boolean
 */
function regex($value,$rule) {
	$validate = array(
		'require'=> '/.+/',
		'email' => '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/',
		'url' => '/^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/',
		'currency' => '/^\d+(\.\d+)?$/',
		'number' => '/^\d+$/',
		'zipcode' => '/^[1-9]\d{5}$/',
		'integer' => '/^[-\+]?\d+$/',
		'double' => '/^[-\+]?\d+(\.\d+)?$/',
		'english' => '/^[A-Za-z]+$/',
		'en&num' => '/^[A-Za-z0-9]+$/',
	);
	// 检查是否有内置的正则表达式
	if(isset($validate[strtolower($rule)]))
		$rule   =   $validate[strtolower($rule)];
	return preg_match($rule,$value)===1;
}

/**
 * 获取当前URL地址
 * @param string $wipe 要去除的参数，多个要去除的参数用英文逗号分隔
 * @param boolean $encode 是否URL编码，默认进行编码
 * @return string
 */
function get_active_url($wipe = '', $encode = true) {
  $query = $_SERVER['QUERY_STRING'];
  $queryArray = explode('&', $query);
  $wipe = explode(',', str_replace(' ', '', $wipe));
  foreach ($queryArray as $key=>$value) {
    list($key2) = explode('=', $value);
    foreach ($wipe as $w) {
      if ($w == $key2) {
        unset($queryArray[$key]);
        break;
      }
    }
  }
  $query = implode('&', $queryArray);
  $url = strtolower($_SERVER['PHP_SELF'].'?'.$query);
  if ($encode) $url = urlencode($url);
  return $url;
}

/**
 * 对二维数组按照指定键的值排序
 * @param array $array 二维数组
 * @param string $key 键名或索引
 * @param string $type 升序asc(默认)或降序desc
 * @return array
 */
function asort_array($array, $key, $type='asc') {
	$relayArray = $newArray = array();
	foreach ($array as $k1 => $v1) {
		$relayArray[$k1] = $v1[$key];
	}
	if ($type == 'asc') {
		asort($relayArray);
	} else if ($type == 'desc') {
		arsort($relayArray);
	}
	reset($relayArray);
	foreach ($relayArray as $k2 => $v2) {
		$newArray[$k2] = $array[$k2];
	}
	return $newArray;
}

/**
 * 获取模糊时间
 * 计算当前时间与某一时间戳的模糊时间差，例如：20秒前，2天前等等
 * @param integer $time  日期时间戳
 * @return string
 */
function get_fuuzzy_time($time) {
	$interval = time() - $time;
	if ($interval < 60) {
		return $interval.'秒前';
	} else if ($interval < 3600) {
		return floor($interval/60).'分钟前';
	} else if ($interval < 3600*24) {
		return floor($interval/3600).'小时前';
	} else if ($interval < 3600*24*7) {
		return floor($interval/3600/24).'天前';
	} else if ($interval < 3600*24*30) {
		return floor($interval/3600/24/7).'周前';
	} else if ($interval < 3600*24*30*12) {
		return floor($interval/3600/24/30).'月前';
	} else {
		return floor($interval/3600/24/30/12).'年前';
	}
}

/**
 * 自定义加密算法
 * @param string $password
 * @return string
 */
function get_password($password) {
	$password = md5($password);
	$md5A = md5(substr($password, 0, 16));
	$md5B = md5(substr($password, 16, 16));
	$md5 = md5($md5A.$md5B);
	return $md5;
}

/**
 * 获取指定图片缩略图
 * @param string $imagePath 源图片路径
 * @param integer $width 缩略图宽
 * @param integer $height 缩略图高度
 * @param integer $fillAlpha 透明度
 * @param string $fillColor 填充颜色
 * @return string
 */
function get_thumbnail($imagePath, $width, $height, $fillAlpha = 0, $fillColor = '#ffffff') {
	$thumbnailName = C('THUMBNAIL_SAVE_DIR').md5($_SERVER['DOCUMENT_ROOT'].$imagePath.$width.$height.$fillAlpha.$fillColor).'.png';
	$documentRoot = $_SERVER['DOCUMENT_ROOT'].'/';
	if (!file_exists($documentRoot.$thumbnailName)) {
		$image = new ThumbHandler();
		$image->setFillColor($fillColor);
		$image->setFillAlpha($fillAlpha);
		$image->setSrcImg($documentRoot.$imagePath);
		$image->setRectangleCut(50, 50);
		$image->setDstImg($documentRoot.$thumbnailName);
		$image->createImg($width, $height);
	}
	return $thumbnailName;
}

/**
 * 过滤Null值
 * @param $string
 * @return string
 */
function filter_null($string) {
  is_null($string) && $string = '';
  return $string;
}

/*
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @return mixed
 */
function get_client_ip($type = 0) {
  $type = $type ? 1 : 0;
  static $ip = NULL;
  if ($ip !== NULL) return $ip[$type];
  if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
    $pos = array_search('unknown', $arr);
    if (false !== $pos) unset($arr[$pos]);
    $ip = trim($arr[0]);
  } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
  } elseif (isset($_SERVER['REMOTE_ADDR'])) {
    $ip = $_SERVER['REMOTE_ADDR'];
  }
  // IP地址合法验证
  $long = sprintf("%u", ip2long($ip));
  $ip = $long ? array($ip, $long) : array('0.0.0.0', 0);
  return $ip[$type];
}

/**
 * 对象转数组
 * @param $object
 * @return array
 */
function object2array($object) {
  $array = array();
  foreach($object as $k=>$v) {
    (is_array($v) || is_object($v)) && $v = object2array($v);
    $array[$k] = $v;
  }
  return $array;
}

/*
 * 获取数组指定键
 * @param array
 * @param string $filed 要获取的键名
 * @param string $separator 连接键值的分隔符
 * @return string
 */
function get_field_list($array, $filed, $separator = ',') {
  foreach($array as $k1=>$v1) {
    $filedList .= (isset($filedList) ? $separator : '').$v1[$filed];
  }
  return $filedList;
}

/*
 * URL重定向
 * @param string $url 重定向的URL地址
 * @param integer $time 重定向的等待时间（秒）
 * @param string $msg 重定向前的提示信息
 */
function redirect($url, $time = 0, $msg = '') {
  //多行URL地址支持
  $url = str_replace(array("\n", "\r"), '', $url);
  if (empty($msg)) {
    $msg = "系统将在{$time}秒之后自动跳转到{$url}！";
  }
  if (!headers_sent()) {
    //redirect
    if (0 === $time) {
      header('Location: ' . $url);
    } else {
      header("Content-Type:text/html; charset=".C('DEFAULT_CHARSET'));
      header("refresh:{$time};url={$url}");
      echo($msg);
    }
    exit();
  } else {
    $str = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
    if ($time != 0) {
      $str .= $msg;
    }
    exit($str);
  }
}

/**
 * 配置数据为|1,|2,|3,样式
 * @param array $array 字符串
 * @return string
 */
function set_config($array) {
  $string = implode(',|', $array);
  if ($string != '') { $string = '|'.$string.',';}
  return $string;
}

function ajax_exit($message) {
	$res = array();
	$res['message'] = $message;
	exit(json_encode($res));
}

function echo_json($res) {
	exit(json_encode($res));
}