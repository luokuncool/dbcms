<?php
class Setting extends HOME_Controller {

    public function __construct()
    {
        parent::__construct();
    }

	/**
	 * 主题设置
	 * @author Quentin
	 * @since  2014-12-01 17:05
	 *
	 * @access public
	 * @return void
	 */
    public function theme()
    {
        $data['themeList'] = config_item('themeList');
        if (!is_post()) {
            parent::set_html_header();
            $this->smarty->view('home/setting/theme.tpl', $data);
            return;
        }
		$myTheme = I('post.myTheme', 'default', 'strip_tags,trim');
		in_array($myTheme, $data['themeList']) ? setcookie('myTheme', $myTheme, time()+3600*3600, '/') : ajax_exit('主题不存在');
		$res['message'] = '设置成功';
		$res['reload'] = 1;
		$res['reloadType'] = 1;
		$res['success'] = 1;
		echo_json($res);
    }

	/**
	 * 常用菜单
	 * @author Quentin
	 * @since  2014-12-01 17:05
	 *
	 * @access public
	 * @return void
	 */
	public function favorite_menu()
	{
		if (!is_post()) {
			$userId = get_uid();
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
			return;
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
	 * @author Quentin
	 * @since  2014-12-01 17:04
	 *
	 * @access public
	 * @return void
	 */
	public function set_favorite_menu()
	{
		if (!is_post()) {
			return;
		}
		$userId = get_uid();
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
	 * 密码修改
	 * @author Quentin
	 * @since  2014-12-01 17:04
	 *
	 * @access public
	 * @return void
	 */
	public function change_password()
	{
		if (!is_post()) {
			parent::set_html_header();
			$this->smarty->view('home/setting/change_password.tpl');
			return;
		}
		$this->load->model('user_model');
		$user = $this->user_model->get_row(get_uid());
		$oldPassword = I('post.oldPassword', '', 'trim');
		$password    = I('post.password', '', 'trim');
		$rePassword  = I('post.rePassword', '', 'trim');
		$user['password'] == md5($oldPassword) OR ajax_exit('旧密码错误');
		regex($password, 'require')            OR ajax_exit('请输入新密码');
		$rePassword == $password               OR ajax_exit('两次密码输入不一致');
		$result = $this->user_model->update('id = '.$user['id'], array('password' => md5($password)));
		$result === false                      && ajax_exit('数据保存失败，请稍后再试');
		echo_json(
			array(
				'message' => '保存成功',
				'success' => 1
			)
		);
	}

}