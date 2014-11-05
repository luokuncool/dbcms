<?php
/**
 * HyLogin多功能用户登录类 v2.0.0
 *
 * 提供三种登录模式：1.多IP多浏览器登录（默认） 2.单IP多浏览器登录  3.单IP单浏览器登录
 * 状态码说明：
 * 000 数位依次对应：
 * 账号登录状态 已登录为1 未登录为0
 * 当前活动中IP 与本地一致为1 不一致为0
 * 当前活动中sid 与本地一致为1 不一致为0
 *
 * 011 - 正常，账号未登录
 * 100 - 异常，账号已登录（被弹出），于另一IP登录
 * 110 - 异常，账号已登录（被弹出），于另一浏览器登录
 * 111 - 正常，账号已登录
 * 特殊情况
 * 001 - 异常，数据缺失
 * 101 - 正常，可Cookie登录
 *
 * Copyright (c) 2013 YinHailin All rights reserved.
 * @Author: YinHailin
 * @Authorize: Boren Network
 * @Created by YinHailin at 2013-11-20
 */

class Login {

  /* 是否单IP登录 */
  public $isThisIp = false;

  /* 是否单浏览器登录 */
  public $isThisBrowser = false;

  /* cookie、session名称 */
  public $keyName = 'hy';

  /* cookie超时时间(天) */
  public $tokenTimeout = 1;

  /* session超时时间，不能超过php.ini配置时间(秒) */
  public $sidTimeOut = '1200';

  /* 当前活动中的账号IP */
  public $activeIp = '';

  /* 当前活动中的账号SID */
  public $activeSid = '';

  /* 当前账号最后活动时间 */
  public $activeTime = '';

  /**
   * 初始化
   * @param string $keyName
   * @param string $tokenTimeout
   * @param string $sidTimeOut
   * @param string $isThisIp
   * @param string $isThisBrowser
   */
  public function init($keyName = '', $tokenTimeout = '', $sidTimeOut = '', $isThisIp = '', $isThisBrowser = '')
  {
    //cookie、session名称，单IP登录，单浏览器登录初始化
    if ($keyName != '') { $this->keyName = $keyName;}
    if ($isThisIp != '') { $this->isThisIp = (bool)$isThisIp;}
    if ($isThisBrowser != '') { $this->isThisBrowser = (bool)$isThisBrowser;}
    //cookie、session超时时间初始化
    if (intval($tokenTimeout) > 0) { $this->tokenTimeout = intval($tokenTimeout);}
    if (intval($sidTimeOut) > 0) { $this->sidTimeOut = intval($sidTimeOut);}
  }

  /*
   * 活动用户信息配置
   * @param string $activeIp 当前活动中的账号IP
   * @param string $activeSid 当前活动中的账号SID
   * @param string $activeTime 当前账号最后活动时间
   */
  public function set_login_info($activeIp, $activeSid, $activeTime) {
    //活动中的IP，SID，时间初始化
    $this->activeIp = strval($activeIp);
    $this->activeSid = strval($activeSid);
    $this->activeTime = strval($activeTime);
  }

  /*
   * 密码登录
   + 密码登录仅提供密码登录存储方式，即用于存储密码登录通过后相关信息的存储
   + $key, $token, $sid 为完成密码登录存储必要的信息
   * @param string $key 关键参数，用于与数据库关联
   * @param string $token cookie验证散列值
   * @param string $sid session验证散列值
   * @return string
   */
  public function set_password_login($key, $token, $sid) {
    $expire = mktime(date('H'), date('i'), date('s'), date('n'), date('j')+$this->tokenTimeout);
    if ($key == '' || $token == '' || $sid == '') return '001';  //信息缺失
    $status = '1'.$this->_get_this_status();
    //写入cookie
    setcookie($this->keyName.'_key', $key, $expire, '/');
    setcookie($this->keyName.'_token', $token, $expire, '/');
    setcookie($this->keyName.'_sid', $sid, $expire, '/');
    //写入session
    $_SESSION[$this->keyName]['key'] = $key;
    $_SESSION[$this->keyName]['token'] = $token;
    $_SESSION[$this->keyName]['sid'] = $sid;
    $_SESSION[$this->keyName]['status'] = $status;
    return $status;
  }

  /*
   * cookie登录
   * @param string $token cookie验证散列值
   * @param boolean $isForce 是否强行登录，默认为假
   * @return string
   */
  public function set_cookie_login() {
    $status = '1'.$this->_get_this_status();
    //写入session
    $_SESSION[$this->keyName]['key'] = $_COOKIE[$this->keyName.'_key'];
    $_SESSION[$this->keyName]['token'] = $_COOKIE[$this->keyName.'_token'];
    $_SESSION[$this->keyName]['sid'] = $_COOKIE[$this->keyName.'_sid'];
    $_SESSION[$this->keyName]['status'] = $status;
    return $status;
  }

  /*
   * 退出登录
   * @return string
   */
  public function set_logout() {
    //清除session
    unset($_SESSION[$this->keyName]);
    //清除cookie
    $expire = mktime(date('H'), date('i'), date('s'), date('n'), date('j')-$this->tokenTimeout);
    $token = md5(time());
    setcookie($this->keyName.'_key', $token, $expire);
    setcookie($this->keyName.'_token', $token, $expire);
    setcookie($this->keyName.'_sid', $token, $expire);
    return '000';
  }

  /*
   * 获取登录状态
   * @param string $token 即时token散列值，用于检测token是否已经改变
   * @return string
   */
  public function get_login_status($token) {
    $thisStatus = $this->_get_this_status();
    if (isset($_COOKIE[$this->keyName.'_token']) && $_COOKIE[$this->keyName.'_token'] == $token) {
      if (isset($_SESSION[$this->keyName]) && $_SESSION[$this->keyName] != '') {
        if ($this->isThisIp && $thisStatus == '00') {
          //异常，账号在另一IP登录
          return '100';
        } elseif ($this->isThisBrowser && $thisStatus == '10') {
          //异常，账号在另一浏览器登录
          return '110';
        } else {
          //正常已登录
          return '111';
        }
      } else {
        return '101';
      }
    } else {
      return '011';
    }
  }

  /*
   * 当前IP、当前浏览器登录判断
   * @return string
   */
  private function  _get_this_status() {
    $expire = mktime(date('H'), date('i'), date('s')-$this->sidTimeOut);
    if ($this->activeTime < $expire || !$this->isThisIp || !($this->isThisIp && $this->isThisBrowser)) {
      $status = '11';
    } else {
      $status = $this->activeIp == $this->_get_client_ip() || $this->activeIp == '' ? '1' : '00';
      if ($status == '1') $status .= ($this->activeSid == $_COOKIE[$this->keyName.'_sid']) || $_COOKIE[$this->keyName.'_sid'] == '' ? '1' : '0';
    }
    return $status;
  }

  /* 获取浏览器IP地址 */
  private function _get_client_ip() {
    static $ip = NULL;
    if ($ip !== NULL) return $ip;
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
      $pos = array_search('unknown',$arr);
      if (false !== $pos) unset($arr[$pos]);
      $ip = trim($arr[0]);
    } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
      $ip = $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $ip = (false !== ip2long($ip)) ? $ip : '0.0.0.0';
    return $ip;
  }
}