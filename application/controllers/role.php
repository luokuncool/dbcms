<?php
class Role extends HOME_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(
			array('role_model')
		);
	}

	/**
	 * 角色列表
	 */
	public function index()
	{
		$data['groupList']   = config_item('role_group');
		$data['editable']    = 0;
		$data['searchBlockHeight'] = 42;
		$data['editHandler'] = 'role.editHandler';
		if (!IS_AJAX)
		{
			parent::set_html_header();
			$data['page_title'] = '前台首页';
			$data['data_grid_url'] = '/role/index';
			$this->smarty->view('home/role/index.tpl', $data);
			return;
		}

		$map = array();
		$sort = $this->input->get('sort');
		$order = $this->input->get('order');
		$map['order_by'] = ($sort && $order) ? array($sort, $order) : array('id', 'asc');

		$code = $this->input->get('code');
		$code && $map[] = 'code LIKE "%'.$code.'%"';

		$status = $this->input->get('status');
		$status != '' && $map[] = array('status'=>intval($status));
		$name = $this->input->get('name');
		$name != '' && $map[] = 'name LIKE "%'.$name.'%"';

		$page = intval($this->input->get('page'));
		$rows = intval($this->input->get('rows'));
		$map['limit'] = array($rows, ($page ? $page-1 : 0)*$rows);

		$list = $this->role_model->get_list($map, 'id,name,status,remark');
		foreach($list['rows'] as $key=>$value)
		{
			//$list['rows'][$key]['opt'] = '<a class="easyui-linkbutton icon-add" data-options="iconCls:\'icon-add\'" href="javascript:parent.App.addTab(\'添加节点\', \'/role/create\');" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">&nbsp;</a>';
		}
		echo json_encode($list);
	}

	/**
	 * 创建节点
	 */
	public function create()
	{
		$pId = intval($this->input->get('pId'));
		$data['pId'] = $pId;
		$data['role_group_list'] = config_item('role_group');
		if (!$_POST)
		{
			$this->smarty->view('home/role/create.tpl', $data);
			return;
		}
		$code = $this->input->post('code');
		$name = $this->input->post('name');
		$currentTime = time();
		regex($code, 'require') OR exit('{"message":"请填写操作代码！"}');
		regex($name, 'require') OR exit('{"message":"请填写显示名！"}');
		$data = array(
			'code' => $code,
			'name' => $name,
			'status' => intval($this->input->post('status')),
			'remark' => $this->input->post('remark'),
			'sort' => $this->input->post('sort'),
			'groupId' => intval($this->input->post('groupId')),
			'pId' => $pId,
			'level' => $this->input->post('level'),
			'type' => $this->input->post('type'),
			'createTime' => $currentTime,
			'updateTime' => $currentTime,
			'createUid' => 1,
			'updateUid' => 1,
		);
		$id = $this->role_model->insert($data);
		$res['message'] = $id ? '添加成功' : '添加失败';
		$id && $res['success'] = 1;
		$id && $res['reload'] = 1;
		echo json_encode($res);
	}

	/**
	 * 修改节点
	 * @param $id
	 */
	public function edit($id)
	{
		$id = intval($id);
		if (!$_POST)
		{
			$data['role_group_list'] = config_item('role_group');
			$data['data']            = $this->role_model->get_row($id);
			$this->smarty->view('home/role/edit.tpl', $data);
			return;
		}
		$name        = I('post.name', '', 'strip_tags,trim');
		regex($name, 'require') OR ajax_exit('请填写角色名！');
		$exist       = $this->role_model->check_name($name.' AND id<>'.$id);
		$exist && ajax_exit('角色名已经存在！');

		$currentTime = time();
		$data = array(
			'name' => $name,
			'status' => intval($this->input->post('status')),
			'remark' => $this->input->post('remark'),
			'updateTime' => $currentTime,
			'updateUid' => 1,
		);
		$result = $this->role_model->update(array('id'=>$id), $data);
		$result OR ajax_exit('保存失败');

		$res['message'] = '保存成功';
		$res['success'] = 1;
		$res['reload'] = 1;
		echo_json($res);
	}

	/**
	 * 禁用角色
	 */
	public function disable()
	{
		if (!$_POST) {
			return;
		}
		$roleIds = $this->input->post('roleId');
		regex($roleIds, 'require') OR ajax_exit('请选择角色!');
		$result = $this->set_status('id in('.$roleIds.')', 0);
		$res = array(
			'message' => $result  !== false  ? '操作成功' : '操作失败',
			'success' => $result  !== false  ? 1 : 0,
		);
		echo_json($res);
	}

	/**
	 * 启用角色
	 */
	public function enable()
	{
		if (!$_POST) {
			return;
		}
		$roleIds = $this->input->post('roleId');
		regex($roleIds, 'require') OR ajax_exit('请选择角色!');
		$result = $this->set_status('id in('.$roleIds.')', 1);
		$res = array(
			'message' => $result  !== false ? '操作成功' : '操作失败',
			'success' => $result  !== false  ? 1 : 0,
		);
		echo_json($res);
	}

	/**
	 * todo 设置权限
	 * @param $id
	 */
	public function set_rights($id)
	{
		$this->load->model('node_model');
		$where = array();
		$where[] = array('status'=>1);
		$where[] = array('level'=>1);

		$nodeList = $this->node_model->get_list($where, '*');
		print_r($nodeList); exit();
		$rightsList = array();
		while($nodeList) {
			foreach($nodeList as $key=>$node) {
				if ($node['level'] == 1) $rightsList = array_splice($nodeList, $key, 1);
			}
		}
		$node = $this->role_model->get_row($id);
		$assign['node'] = $node;
		$this->smarty->view('home/role/set_rights.tpl', $assign);
	}

	/**
	 * 设置角色状态
	 * @param $where
	 * @param $status
	 * @return mixed
	 */
	private function set_status($where, $status) {
		return $this->role_model->update($where, array('status'=>$status));
	}

}

/* End of file role.php */
/* Location: ./application/controllers/role.php */