<?php
class Index extends ADMIN_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('admin_model');
  }

  /**
   * 后台首页
   */
  public function index()
  {
    $phpsys = array(
      'php_uname'=>php_uname(),
      'php_gd'=>function_exists('gd_info'),
      'php_version'=>PHP_VERSION,
      'php_port'=>$_SERVER['SERVER_PORT'],
      'php_software'=>$_SERVER['SERVER_SOFTWARE'],
      'php_max_time'=>get_cfg_var('max_execution_time').'s',
      'php_sapi_name'=>php_sapi_name(),
    );
    $data['phpsys'] = $phpsys;

    $this->smarty->view('admin/index/index.tpl', $data);
  }

  /**
   * 管理员登录
   */
  public function login()
  {
    if($_POST)
    {
      parent::set_json_header();
      $POST = deep_htmlspecialchars($_POST);
      $this->load->library('form_validation');
      //用户名验证
      $this->form_validation->required($POST['login_name']) OR
      exit('{"message":"请填写用户名", "selector":"[name=login_name]"}');
      //密码验证
      $this->form_validation->required($POST['password']) OR
      exit('{"message":"请填写密码", "selector":"[name=password]"}');
      //验证码验证
      $this->form_validation->required($POST['code']) OR
      exit('{"message":"请填写验证码", "selector":"[name=code]"}');
      $this->form_validation->matches($_SESSION['checkcode'], 'code') OR exit('{"message":"验证错误", "selector":"[name=code]"}');
      //数据表验证
      $query = $this->db->get_where($this->admin_model->admin_table, array('login_name'=>$POST['login_name'], 'password'=>md5($POST['password'])));
      $query->num_rows OR exit('{"message":"用户名或密码错误"}');
      $find = $query->row_array();
      $find['status'] == '0' && exit('{"message":"帐号被禁用"}');
      $status = parent::set_admin_login(1, $find['id']);
      if ($status == '111')
      {
        echo '{"success":1,"message":"登录成功"}';
      }
      else
      {
        echo '{"message":"系统繁忙，请稍后再试"}';
      }
    }
    else
    {
      parent::set_html_header();
      $this->smarty->view('admin/index/login.tpl');
    }
  }

  /**
   * 设置站点信息
   */
  public function site_info()
  {
    if ($_POST)
    {
      $this->set_json_header();
      $this->load->library('form_validation');
      $this->load->helper('array_helper');
      $POST = deep_htmlspecialchars($_POST);
      $this->form_validation->required($POST['site_name']) OR exit('{"message":"请填写站点名称", "selector":"[name=site_name]"}');
      $data = elements(array('site_name', 'site_url', 'company', 'address', 'zipcode', 'telephone', 'cellphone', 'email', 'icp'), $POST);
      $this->db->update('site', $data);
      echo '{"success":1,"message":"保存成功"}';
    }
    else
    {
      $this->set_html_header();
      $this->smarty->view('admin/index/site_info.tpl');
    }
  }

  /**
   * 退出登录
   */
  public function logout()
  {
    $active_admin = parent::get_active_admin();
    parent::set_admin_login(0, $active_admin['id']);
    echo '{"success":1,"message":"成功退出"}';
  }

  /**
   * 密码修改
   */
  public function change_password()
  {
    if ($_POST)
    {
      parent::set_json_header();
      $this->load->library('form_validation');
      $POST = deep_htmlspecialchars($_POST);
      $active_admin = $this->admin->active_admin;
      $active_admin = $this->admin_model->get_admin($active_admin['id']);
      md5($POST['old_password']) == $active_admin['password'] OR exit('{"message":"旧密码输入不正确！", "selector":"[name=old_password]"}');
      $this->form_validation->required($POST['password']) OR exit('{"message":"请输入新密码！", "selector":"[name=password]"}');
      $POST['password'] == $POST['re_password'] OR exit('{"message":"两次密码输入不一致！", "selector":"[name=re_password]"}');
      $this->admin_model->update_admin(array('id'=>$active_admin['id']), array('password'=>md5($POST['password'])));
      echo '{"success":1,"message":"密码修改成功！"}';
    }
    else
    {
      parent::set_html_header();
      $this->smarty->view('admin/index/change_password.tpl');
    }
  }

  /**
   * 个人资料
   */
  public function self_info()
  {
    $active_admin = $this->admin->active_admin;
    if ($_POST)
    {
      parent::set_json_header();
      $this->load->library('form_validation');
      $this->load->helper('array_helper');
      $POST = deep_htmlspecialchars($_POST);
      $data = elements(array('real_name', 'email'), $POST);
      $this->admin_model->update_admin(array('id'=>$active_admin['id']), $data);
      echo '{"success":1,"message":"资料修改成功！"}';
    }
    else
    {
      parent::set_html_header();
      $data['data'] = $active_admin;
      $this->smarty->view('admin/index/self_info.tpl', $data);
    }
  }

  /**
   * 清空缓存
   */
  public function clear_cache()
  {
    $this->clear_dir(APPPATH.'/cache/');
    $this->clear_dir(APPPATH.'/templates_c/');
    echo '{"success":1, "message":"操作成功！"}';
  }

  /**
   * 清空缓存
   * @param bool $cache_dir
   */
  private function clear_dir($cache_dir = false)
  {
    if ($cache_dir === false) return;
    $this->load->helper('directory');
    $map = directory_map($cache_dir, 1);
    foreach($map as $file_name) {
      preg_match('#\.php$#', $file_name) && @unlink($cache_dir.$file_name);
    }
  }
}