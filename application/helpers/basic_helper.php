<?php

/**
 * 字符串截取，支持中文和其他编码
 *
 * @param string  $str     需要转换的字符串
 * @param integer $start   开始位置
 * @param integer $length  截取长度
 * @param string  $charset 编码格式
 * @param boolean $suffix  截断显示字符
 *
 * @return string
 */
function msubstr($str, $start = 0, $length, $suffix = true, $charset = "utf-8")
{
    if (function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    elseif (function_exists('iconv_substr')) {
        $slice = iconv_substr($str, $start, $length, $charset);
        if (false === $slice) {
            $slice = '';
        }
    } else {
        $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("", array_slice($match[0], $start, $length));
    }
    switch (strtolower($charset)) {
        case 'utf-8' :
            if (strlen($str) > $length * 3) {
                return $suffix ? $slice . '...' : $slice;
            } else {
                return $slice;
            }
            break;
        default :
            if (strlen($str) > $length) {
                return $suffix ? $slice . '...' : $slice;
            } else {
                return $slice;
            }
    }
}

/**
 * 字符串截取，支持中文UTF-8编码[布局用字符串截取]
 *
 * @param string  $str    需要转换的字符串
 * @param integer $start  开始位置
 * @param integer $length 截取长度
 * @param boolean $suffix 截断显示字符
 *
 * @return string
 */
function lsubstr($str, $start = 0, $length, $suffix = true)
{
    $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
    $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
    $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
    $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
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
            $length = $key + 1;
            break;
        }
    }
    $slice = join("", array_slice($match[0], $start, $length));
    if (count($match[0]) > $length) {
        return $suffix ? $slice . '...' : $slice;
    } else {
        return $slice;
    }
}

/**
 * 使用正则验证数据
 *
 * @param string $value 要验证的数据
 * @param string $rule  验证规则
 *
 * @return boolean
 */
function regex($value, $rule)
{
    $validate = array(
        'require' => '/.+/',
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
    if (isset($validate[strtolower($rule)]))
        $rule = $validate[strtolower($rule)];
    return preg_match($rule, $value) === 1;
}

/**
 * 获取当前URL地址
 *
 * @param string  $wipe   要去除的参数，多个要去除的参数用英文逗号分隔
 * @param boolean $encode 是否URL编码，默认进行编码
 *
 * @return string
 */
function get_active_url($wipe = '', $encode = true)
{
    $query = $_SERVER['QUERY_STRING'];
    $queryArray = explode('&', $query);
    $queryArray = array_filter($queryArray);
    $wipe = explode(',', str_replace(' ', '', $wipe));
    foreach ($queryArray as $key => $value) {
        list($key2) = explode('=', $value);
        foreach ($wipe as $w) {
            if ($w == $key2) {
                unset($queryArray[$key]);
                break;
            }
        }
    }
    $query = implode('&', $queryArray);
    $baseURL = current_url();
    $url = $query == '' ? $baseURL : ($baseURL. '?' .$query);
    if ($encode) $url = urlencode($url);
    return $url;
}

/**
 * 对二维数组按照指定键的值排序
 *
 * @param array  $array 二维数组
 * @param string $key   键名或索引
 * @param string $type  升序asc(默认)或降序desc
 *
 * @return array
 */
function sort_by_key(&$array, $key, $type = 'asc')
{
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
    $array = $newArray;
    return $newArray;
}

/**
 * 获取模糊时间
 * 计算当前时间与某一时间戳的模糊时间差，例如：20秒前，2天前等等
 *
 * @param integer $time 日期时间戳
 *
 * @return string
 */
function get_fuzzy_time($time)
{
    $interval = time() - $time;
    if ($interval < 60) {
        return $interval . '秒前';
    } else if ($interval < 3600) {
        return floor($interval / 60) . '分钟前';
    } else if ($interval < 3600 * 24) {
        return floor($interval / 3600) . '小时前';
    } else if ($interval < 3600 * 24 * 7) {
        return floor($interval / 3600 / 24) . '天前';
    } else if ($interval < 3600 * 24 * 30) {
        return floor($interval / 3600 / 24 / 7) . '周前';
    } else if ($interval < 3600 * 24 * 30 * 12) {
        return floor($interval / 3600 / 24 / 30) . '月前';
    } else {
        return floor($interval / 3600 / 24 / 30 / 12) . '年前';
    }
}

/**
 * 自定义加密算法
 *
 * @param string $password
 *
 * @return string
 */
function get_password($password)
{
    $password = md5($password);
    $md5A = md5(substr($password, 0, 16));
    $md5B = md5(substr($password, 16, 16));
    $md5 = md5($md5A . $md5B);
    return $md5;
}

/**
 * 获取客户端IP地址
 *
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 *
 * @return mixed
 */
function get_client_ip($type = 0)
{
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
 *
 * @param object $object
 *
 * @return array
 */
function object2array($object)
{
    $array = array();
    foreach ($object as $k => $v) {
        (is_array($v) || is_object($v)) && $v = object2array($v);
        $array[$k] = $v;
    }
    return $array;
}

/**
 * 获取数组指定键
 *
 * @param        array
 * @param string $filed     要获取的键名
 * @param string $separator 连接键值的分隔符
 *
 * @return string
 */
function get_field_list($array, $filed, $separator = ',')
{
    $filedList = '';
    foreach ($array as $k1 => $v1) {
        $filedList .= ((bool)$filedList ? $separator : '') . $v1[$filed];
    }
    return $filedList;
}

/**
 * URL重定向
 *
 * @param string  $url  重定向的URL地址
 * @param integer $time 重定向的等待时间（秒）
 * @param string  $msg  重定向前的提示信息
 */
function direct_to($url, $time = 0, $msg = '')
{
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
            header("Content-Type:text/html; charset=" . config_item('charset'));
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
 *
 * @param array $array 字符串
 *
 * @return string
 */
function set_config($array)
{
    $string = implode(',|', $array);
    if ($string != '') {
        $string = '|' . $string . ',';
    }
    return $string;
}

/**
 * 获取输入参数 支持过滤和默认值
 * 使用方法:
 * <code>
 * I('id',0); 获取id参数 自动判断get或者post
 * I('post.name','','htmlspecialchars'); 获取$_POST['name']
 * I('get.'); 获取$_GET
 * </code>
 *
 * @param string $name    变量的名称 支持指定类型
 * @param mixed  $default 不存在的时候默认值
 * @param mixed  $filter  参数过滤方法
 *
 * @return mixed
 */
function I($name, $default = '', $filter = null)
{
    if (strpos($name, '.')) { // 指定参数来源
        list($method, $name) = explode('.', $name);
    } else { // 默认为自动判断
        $method = 'param';
    }

    switch (strtolower($method)) {
        case 'get'     :
            $input =& $_GET;
            break;
        case 'post'    :
            $input =& $_POST;
            break;
        case 'put'     :
            parse_str(file_get_contents('php://input'), $input);
            break;
        case 'param'   :
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'POST':
                    $input = $_POST;
                    break;
                case 'PUT':
                    parse_str(file_get_contents('php://input'), $input);
                    break;
                default:
                    $input = $_GET;
            }
            break;
        case 'request' :
            $input =& $_REQUEST;
            break;
        case 'session' :
            $input =& $_SESSION;
            break;
        case 'cookie'  :
            $input =& $_COOKIE;
            break;
        case 'server'  :
            $input =& $_SERVER;
            break;
        default:
            return NULL;
    }
    // 全局过滤
    // array_walk_recursive($input,'filter_exp');
    if (config_item('var_filters')) {
        $_filters = explode(',', config_item('var_filters'));
        foreach ($_filters as $_filter) {
            // 全局参数过滤
            array_walk_recursive($input, $_filter);
        }
    }
    if (empty($name)) { // 获取全部变量
        $data = $input;
    } elseif (isset($input[$name])) { // 取值操作
        $data = $input[$name];
        $filters = isset($filter) ? $filter : config_item('default_filter');
        if ($filters) {
            $filters = explode(',', $filters);
            foreach ($filters as $filter) {
                if (function_exists($filter)) {
                    $data = is_array($data) ? array_map($filter, $data) : $filter($data); // 参数过滤
                } else {
                    $data = filter_var($data, is_int($filter) ? $filter : filter_id($filter));
                    if (false === $data) {
                        return isset($default) ? $default : NULL;
                    }
                }
            }
        }
    } else { // 变量默认值
        $data = isset($default) ? $default : NULL;
    }
    return $data;
}

/**
 * 输出消息并退出
 *
 * @param $message {string}
 */
function ajax_exit($message)
{
    $res = array();
    $res['message'] = $message;
    exit(json_encode($res));
}

/**
 * 输出json字符并退出
 *
 * @param $res {array|object}
 */
function echo_json($res)
{
    exit(json_encode($res));
}

/**
 * 是否提交表单
 */
function is_post()
{
    return $_SERVER['REQUEST_METHOD'] == 'POST' OR $_POST OR isset($_REQUEST['post']);
}

/**
 * 获取登陆用户id
 * @author Quentin
 * @since  2014-12-01
 *
 * @return int|bool
 */
function get_uid()
{
    return isset($_SESSION['userInfo']) ? $_SESSION['userInfo']['id'] : false;
}

/**
 * 是否是ajax请求
 * @author Quentin
 * @since  2014-12-01
 *
 * @access public
 * @return bool
 */
function is_ajax()
{
    return IS_AJAX OR isset($_REQUEST['ajaxRequest']);
}

/**
 * 获取可以访问节点ID
 * @author Quentin
 * @since  2015-06-23
 * @access public
 *
 * @param bool $isArray
 *
 * @return mixed
 */
function get_access_nodeIds($isArray = false)
{
	return $isArray ? $_SESSION['accessNodeIds'] : join(',', $_SESSION['accessNodeIds']);
}