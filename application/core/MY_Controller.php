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
		$assign['systemName'] = config_item('system_name');
		$assign['baseUrl'] = config_item('base_url');
		$assign['basePath'] = config_item('base_path');
		$assign['activeUrl'] = get_active_url('redirect');
		$this->smarty->assign($assign);
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
        $this->check_login();
		$data['myTheme'] = isset($_COOKIE['myTheme']) ? $_COOKIE['myTheme'] : 'default';
		$data['baseUrl']      = config_item('base_url');
		$data['systemName'] = config_item('system_name');
		$data['pageSetting'] = config_item('pageSetting');
		$this->smarty->assign($data);
	}

    /**
     * 身份验证
     */
    protected function check_login()
    {
        $thisNode = join('/', $this->uri->rsegment_array());
        $withoutCheckLogin = config_item('withoutCheckLogin');
        foreach ( $withoutCheckLogin as $node ) {
            if (preg_match('#^'.$node.'#', $thisNode)) return;
        }
        if ( !isset($_SESSION['userInfo']) ) {
			direct_to('/login');
            exit();
        }
    }

}