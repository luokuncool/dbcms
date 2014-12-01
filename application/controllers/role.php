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
		if (!is_ajax())
		{
			parent::set_html_header();
			$data['dataGridUrl'] = config_item('base_url') . 'role/index';
			$this->smarty->view('home/role/index.tpl', $data);
			return;
		}

		$map             = array();
		$name            = I('get.name', '', 'strip_tags,trim');
		$name           != '' && $map[] = 'name LIKE "%'.$name.'%"';

		$status          = I('get.status', '', 'strip_tags,trim');
		$status         != '' && $map[] = array('status'=>intval($status));

		$sort            = I('get.sort', 'id', 'strip_tags,trim');
		$order           = I('get.order', 'desc', 'strip_tags,trim');
		$map['order_by'] = array($sort, $order);

		$page            = I('get.page', 1, 'intval');
		$rows            = I('get.rows', config_item('pageSize'));
		$map['limit']    = array($rows, ($page-1)*$rows);

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
		if (!is_post())
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
		if (!is_post())
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
			'status' => I('post.status', '', 'intval'),
			'remark' => I('post.remark', '', 'strip_tags,trim'),
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
		$roleIds = I('post.ids', '', 'strip_tags,trim');
		regex($roleIds, 'require') OR ajax_exit('请选择角色!');
		$result = $this->set_status('id in('.$roleIds.')', 0);
		$result === false && ajax_exit('操作失败');
		$res = array(
			'message' => '操作成功',
			'success' => 1,
			'reloadType' => 2
		);
		echo_json($res);
	}

	/**
	 * 启用角色
	 */
	public function enable()
	{
		if (!is_post()) {
			return;
		}
		$roleIds = I('post.ids', '', 'strip_tags,trim');
		regex($roleIds, 'require') OR ajax_exit('请选择角色!');
		$result = $this->set_status('id in('.$roleIds.')', 1);
		$result === false && ajax_exit('操作失败');
		$res = array(
			'message' => '操作成功',
			'success' => 1,
			'reloadType' => 2
		);
		echo_json($res);
	}

	/**
	 * 设置角色用户
	 * @param $id
	 */
	public function set_user($id) {
		$id = intval($id);
		if (!is_post())
		{
			$this->load->model('role_user_model');
			parent::set_html_header();
			//已选中角色
			$assign['roleUsers']         = $this->role_user_model->get_list(array('roleId'=>$id), 'userId');
			$userIds = '';
			$rows = $assign['roleUsers']['rows'];
			foreach($rows as $row) {
				$userIds .= $userIds !== ''  ?  ','.$row['userId'] : $row['userId'];
			}
			$assign['userIds']           = $userIds;
			$assign['roleId']            = $id;
			$assign['dataGridUrl']       = config_item('base_url') . 'user/index';
			$this->smarty->view('home/role/set_user.tpl', $assign);
			return;
		}
		$usersId = array_filter(explode(',', I('post.users', '', 'strip_tags,trim')));
		$this->load->model('role_user_model');
		$roleUsers = array();
		foreach($usersId as $userId) {
			$roleUsers[] = array(
				'roleId' => $id,
				'userId' => $userId
			);
		}
		$this->role_user_model->delete(array('roleId'=>$id));
		if ($usersId) {
			$result = $this->role_user_model->batch_insert($roleUsers);
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