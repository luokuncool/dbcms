<?php
/**
 * 基础控制器
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-7-24
 * Time: 下午5:13
 */
class MY_Controller extends CI_Controller {

  /**
   * 构造函数
   */
  public function __construct()
  {
    parent::__construct();
	return;
    $this->load->model('site_model');
    $site_info = $this->site_model->get_site_info();
    $this->smarty->assign('base_url', $this->config->config['base_url']);
    $this->smarty->assign('base_path', $this->config->config['base_path']);
    $this->smarty->assign('site_info', $site_info);
    $this->smarty->assign('page_title', $site_info['site_name']);
    $this->smarty->assign('active_url', get_active_url('redirect'));
  }

  /**
   * 设置HTML输出的header
   */
  public function set_html_header()
  {
    header('Content-Type:text/html;charset=utf-8;');
  }

  /**
   * 设置JSON输出的header
   */
  public function set_json_header()
  {
    header('Content-Type:text/json;charset=utf-8;');
  }

  /**
   * 后台管理员登录
   * @param $type
   * @param string $id
   * @return string
   */
  public function set_admin_login($type, $id = '')
  {
    $this->load->model('admin_model');
    $this->load->helper('array');

    if ($type != 1 && $type != 2) { $type = 0;}  //取值限定

    //数据库写入
    $user = $this->admin_model->get_admin($id);
    if (!$user) { return '0100';}
    if (intval($type) === 2) {
      $data['active_sid'] = $_COOKIE[C('ADMIN_NAME').'_sid'];
    } else {
      $data['active_sid'] = md5(rand(1000, 9999).'_hy');
    }
    $data['active_time'] = time();
    $data['last_login_ip'] = get_client_ip();
    $data['last_login_time'] = $data['active_time'];
    $data['login_times'] = $user['login_times']+1;
    if ($user['active_token'] == '') {
      $data['active_token'] = md5(rand(1000, 9999).'_hy');
      $user['active_token'] = $data['active_token'];
    }
    if ($type > 0) { $this->db->update($this->admin_model->admin_table, $data, 'id = '.intval($id));}
    //配置信息
    $config = elements(array('name', 'token_timeout', 'sid_timeout', 'this_ip', 'this_browser'), $this->config->config);
    //用户信息
    $user = array('key' => $user['id'], 'token' => $user['active_token'], 'sid' => $data['active_sid'], 'time' => $data['active_time'], 'ip' => $data['last_login_ip']);
    return parent::set_login($type, $user, $config);
  }

  /**
   * 用户登录
   */
  public function set_login($type, $user, $config = array())
  {
    $this->load->library('Login');
    $this->login->init($config['name'], $config['token_timeout'], $config['sid_timeout'], $config['this_ip'], $config['this_browser']);
    $this->login->set_login_info($user['ip'], $user['sid'], $user['time']);
    switch ($type)
    {
      case 1 :
        //密码登录
        return $this->login->set_password_login($user['key'], $user['token'], $user['sid']);
        break;
      case 2 :
        //Cookie登录
        return $this->login->set_cookie_login();
        break;
      case 3 :
        //获取登录状态
        return $this->login->get_login_status($user['token']);
        break;
      default :
        //退出登录
        return $this->login->set_logout();
    }
  }

}

/**
 * 前台基础类
 * Class Home_Controller
 */
class Home_Controller extends MY_Controller {

  /**
   * 构造函数
   */
  public function __construct()
  {
    parent::__construct();
	return;
    $this->load->model(
      array('user_model', 'link_model')
    );
    $site_info = $this->site_model->get_site_info();
    $this->smarty->assign('site_info', $site_info);
    $this->smarty->assign('page_title', $site_info['site_name']);
    //缓存网站信息
    $this->home->site_info = $site_info;
    //登录会员
    $this->smarty->assign('active_user', $this->get_active_user());
    //友情链接
    $text_link_list = $this->link_model->get_link_list('link.status="1" AND link.sort_id=1', 20);
    $text_link_list = deep_htmlspecialchars_decode($text_link_list);
    $this->smarty->assign('text_link_list', $text_link_list);
    $picture_link_list = $this->link_model->get_link_list('link.status="1" AND link.sort_id=2', 20);
    $picture_link_list = deep_htmlspecialchars_decode($picture_link_list);
    $this->smarty->assign('picture_link_list', $picture_link_list);
  }

  /**
   * 后台管理员登录
   * @param $type
   * @param string $id
   * @return string
   */
  public function set_user_login($type, $id = '')
  {
    $this->load->model('user_model');
    $this->load->helper('array');

    if ($type != 1 && $type != 2) { $type = 0;}  //取值限定

    //数据库写入
    $user = $this->user_model->get_user($id);
    if (!$user) { return '0100';}
    if (intval($type) === 2) {
      $data['active_sid'] = $_COOKIE[C('ADMIN_NAME').'_sid'];
    } else {
      $data['active_sid'] = md5(rand(1000, 9999).'_hy');
    }
    $data['active_time'] = time();
    $data['last_login_ip'] = get_client_ip();
    $data['last_login_time'] = $data['active_time'];
    $data['login_times'] = $user['login_times']+1;
    if ($user['active_token'] == '') {
      $data['active_token'] = md5(rand(1000, 9999).'_hy');
      $user['active_token'] = $data['active_token'];
    }
    if ($type > 0) { $this->db->update($this->user_model->user_table, $data, 'id = '.intval($id));}
    //配置信息
    $config = elements(array('name', 'token_timeout', 'sid_timeout', 'this_ip', 'this_browser'), $this->config->config['user_login']);
    //用户信息
    $user = array('key' => $user['id'], 'token' => $user['active_token'], 'sid' => $data['active_sid'], 'time' => $data['active_time'], 'ip' => $data['last_login_ip']);
    return $this->set_login($type, $user, $config);
  }

  /**
   * 获取登录会员
   */
  public function get_active_user()
  {
    $CI = $this->get_instance();
    if ($CI->home->active_user)
    {
      return $CI->home->active_user;
    }
    else
    {
      $user_login_session = $_SESSION[$this->config->config['user_login']['name']];
      if ($user_login_session)
      {
        $user_id = $user_login_session['key'];
        $user = $this->user_model->get_user($user_id);
        unset($user['password']);
        $CI->home->active_user = $user;
        return $user;
      }
    }
  }

}

/**
 * 后台基础类
 * Class ADMIN_Controller
 */
class ADMIN_Controller extends MY_Controller {

  /**
   * 构造函数
   */
  public function __construct()
  {
    parent::__construct();
    $this->load->model(array('admin_model', 'admin_router_model', 'admin_menu_model'));
    $this->check_purview();
  }

  /**
   * 检测权限
   */
  public function check_purview()
  {
    //登录判断
    $active_admin = $this->get_active_admin();
    $this->admin->active_admin = $active_admin;
    if ($this->uri->uri_string == 'admin/login')
    {
      $active_admin && redirect($this->config->config['base_url'].'/admin/site_info');
    } else {
      $active_admin || redirect($this->config->config['base_url'].'/admin/login');
    }
    //自动添加权限条目
    $result = $this->admin_router_model->get_router(
      array(
        'directory' => $this->router->directory,
        'class' => $this->router->class,
        'method' => $this->router->method,
      )
    );
    //不设置权限的访问地址
    $no_purview = array(
      '#^link/.+?_sort$#','#^link/sort_list$#','#^index/login$#','#^index/index$#'
    );
    $without_purview = true;
    foreach($no_purview as $regex)
    {
      if (preg_match($regex, $this->router->class.'/'.$this->router->method)) $without_purview = false;
    }
    if (APP_DEBUG)
    {
      if (!$result && $without_purview)
      {
        $this->admin_router_model->add_router(
          array(
            'directory' => $this->router->directory,
            'class' => $this->router->class,
            'method' => $this->router->method,
            'menu_name' => $this->router->directory.$this->router->class.'/'.$this->router->method,
          )
        );
      }
    }
    else
    {
      $result || redirect($this->config->config['base_url'].'/admin');
    }
    //权限检测
    if (!$without_purview && !in_array($result['id'], unserialize($active_admin['purview_key'])) && $active_admin['id'] != '1')
    {
      if (IS_AJAX)
      {
        $this->set_json_header();
        die('{"message":"没有操作权限！"}');
      }
      else
      {
        $this->set_html_header();
        die('没有操作权限!');
      }
    }
    if($active_admin)
    {
      $this->set_menu();
    }
    //当前登录用户
    $this->smarty->assign('active_admin', $this->admin->active_admin);
    //当前访问路由
    $this->smarty->assign('current_router', $result);
  }

  /**
   * 设置管理菜单
   */
  public function set_menu()
  {
    $active_admin = $this->admin->active_admin;
    $active_admin['purview_key'] = join(',', unserialize($active_admin['purview_key']));
    $active_admin['purview_key'] || header('location:/admin/login');
    //侧栏菜单
    $side_menu_list = $this->admin_router_model->get_menu_group_list($active_admin['id']=='1' ? '' : 'id in('.$active_admin['purview_key'].')');
    $this->smarty->assign('side_menu_list', $side_menu_list);
    //顶部菜单
    $top_menu_list = $this->admin_menu_model->get_admin_menu_list('admin_id='.$active_admin['id']);
    $this->smarty->assign('top_menu_list', $top_menu_list);
  }

  /**
   * 获取登录管理员
   */
  public function get_active_admin()
  {
    $CI = &get_instance();
    if ($CI->home->active_admin)
    {
      return $CI->home->active_admin;
    }
    else
    {
      $admin_login_session = $_SESSION[$this->config->config['admin_login']['name']];
      if ($admin_login_session)
      {
        $admin_id = $admin_login_session['key'];
        $admin = $this->admin_model->get_admin($admin_id);
        unset($admin['password']);
        $CI->admin->active_admin = $admin;
        return $admin;
      }
    }
  }
  /**
   * 后台管理员登录
   * @param $type
   * @param string $id
   * @return string
   */
  public function set_admin_login($type = 0, $id = '')
  {
    $this->load->model('admin_model');
    $this->load->helper('array');

    if ($type != 1 && $type != 2) { $type = 0;}  //取值限定

    //数据库写入
    $user = $this->admin_model->get_admin($id);
    if (!$user) { return '0100';}
    if (intval($type) === 2) {
      $data['active_sid'] = $_COOKIE[C('ADMIN_NAME').'_sid'];
    } else {
      $data['active_sid'] = md5(rand(1000, 9999).'_hy');
    }
    $data['active_time'] = time();
    $data['last_login_ip'] = get_client_ip();
    $data['last_login_time'] = $data['active_time'];
    $data['login_times'] = $user['login_times']+1;
    if ($user['active_token'] == '') {
      $data['active_token'] = md5(rand(1000, 9999).'_hy');
      $user['active_token'] = $data['active_token'];
    }
    if ($type > 0) { $this->db->update($this->admin_model->admin_table, $data, 'id = '.intval($id));}
    //配置信息
    $config = elements(array('name', 'token_timeout', 'sid_timeout', 'this_ip', 'this_browser'), $this->config->config['admin_login']);
    //用户信息
    $user = array('key' => $user['id'], 'token' => $user['active_token'], 'sid' => $data['active_sid'], 'time' => $data['active_time'], 'ip' => $data['last_login_ip']);
    return parent::set_login($type, $user, $config);
  }

}