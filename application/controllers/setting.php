<?php
class Setting extends HOME_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 主题设置
     */
    public function theme()
    {
        $data['themeList'] = config_item('themeList');
        if (!$_POST) {
            parent::set_html_header();
            $this->smarty->view('home/setting/theme.tpl', $data);
            return;
        }
		$myTheme = $this->input->post('myTheme');
		in_array($myTheme, $data['themeList']) ? setcookie('myTheme', $myTheme, time()+3600*3600, '/') : ajax_exit('主题不存在');
		$res['message'] = '设置成功';
		$res['reload'] = 1;
		$res['reloadType'] = 1;
		$res['success'] = 1;
		echo_json($res);
    }

	/**
	 * 常用菜单
	 */
	public function favorite_menu()
	{
		if (!IS_AJAX) {
			$userId = 1; //todo 登陆用户id
			$this->load->model('favorite_menu_model');
			//已有常用菜单
			$assign['menus']         = $this->favorite_menu_model->get_list(array('userId'=>$userId), 'nodeId');
			$nodeIds = '';
			$rows = $assign['menus']['rows'];
			foreach($rows as $row) {
				$nodeIds .= $nodeIds !== ''  ?  ','.$row['nodeId'] : $row['nodeId'];
			}
			$assign['nodeIds']           = $nodeIds;
			$assign['dataGridUrl'] = config_item('base_url') . 'setting/favorite_menu';
			$this->smarty->view('home/setting/favorite_menu.tpl', $assign);
		}
		$this->load->model('node_model');

		$where[] = array(
			'status' => 1,
			'type' => 1
		);

		$sort  = I('get.sort', 'code', 'strip_tags,trim');
		$order = I('get.order', 'asc', 'strip_tags,trim');
		$where['order_by'] = array($sort, $order);

		$name    = I('get.name', '', 'strip_tags,trim');
		$name   != '' && $where[] = 'name LIKE "%'.$name.'%"';

		$page = I('get.page', '1', 'intval');
		$rows = I('get.rows', config_item('pageSize'), 'intval');
		$map['limit'] = array($rows, ($page-1)*$rows);

		$res = $this->node_model->get_list($where, 'id,code,name,sort');
		echo_json($res);
	}

	/**
	 * 设置常用菜单
	 */
	public function set_favorite_menu()
	{
		if (!IS_AJAX) {
			return;
		}
		$userId = 1; //todo 登陆用户id
		$nodeIds = array_filter(explode(',', I('post.nodeIds', '', 'strip_tags,trim')));
		$this->load->model('favorite_menu_model');
		$favoriteMenu = array();
		foreach($nodeIds as $nodeId) {
			$favoriteMenu[] = array(
				'userId' => $userId,
				'nodeId' => $nodeId
			);
		}
		$this->favorite_menu_model->delete(array('userId'=>$userId));
		if ($nodeIds) {
			$result = $this->favorite_menu_model->batch_insert($favoriteMenu);
			$result OR ajax_exit('保存失败');
		}
		echo json_encode(
			array(
				'message' => '保存成功',
				'success' => 1
			)
		);
	}

	/**
	 * todo 密码修改
	 */
	public function change_password()
	{
		if (!$_POST) {
			parent::set_html_header();
			$this->smarty->view('home/setting/change_password.tpl');
			return;
		}
	}

}