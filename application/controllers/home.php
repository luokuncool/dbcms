<?php
class Home extends HOME_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(
			array('node_model')
		);
	}

	/**
	 * 系统主界面
	 */
	public function index()
	{
		parent::set_html_header();
		$data['page_title'] = '前台首页';
		$data['menuGroupList'] = $this->config->config['node_group'];
		$map[] = array('type'=>1);
		$map['order_by'] = array('sort', 'asc');
		$nodeList  = $this->node_model->get_list($map);
		$data['nodeList'] = $nodeList['rows'];
		foreach($data['menuGroupList'] as $groupId => $menuGroup)
		{
			$menuList = array();
			foreach($nodeList['rows'] as $rowKey=>$row)
			{
				$groupId == $row['groupId'] && array_push($menuList, $row);
			}
			unset($data['menuGroupList'][$groupId]);
			$menuList && $data['menuGroupList'][$groupId]['menuName'] = $menuGroup;
			$menuList && $data['menuGroupList'][$groupId]['menuList'] = $menuList;
		}
		$this->smarty->view('home/index/index.tpl', $data);
	}

	/**
	 * 登陆系统
	 */
	public function login()
	{
		if (!$_POST) {
			$data['page_title'] = '登陆系统';
			$this->smarty->view('home/index/login.tpl', $data);
			return;
		}
		//todo 登陆验证
	}

}