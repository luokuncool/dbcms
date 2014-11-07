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
		$data['groupList']   = $this->config->config['role_group'];
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

		$field = $this->role_model->table.'.*, '.'(select name form '.$this->db->dbprefix.$this->role_model->table.' pTable where pTable.id='.$this->role_model->table.'.pId)';
		$list = $this->role_model->get_list($map);
		$list['sql'] = $this->role_model->last_query();
		$list['map'] = $map;
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
		$data['role_group_list'] = $this->config->config['role_group'];
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
			'remark' => $this->input->post('status'),
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
	 */
	public function edit($id)
	{
		$id = intval($id);
		$data['role_group_list'] = $this->config->config['role_group'];
		$data['data'] = $this->role_model->get_row($id);
		if (!$_POST)
		{
			$this->smarty->view('home/role/edit.tpl', $data);
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
			'remark' => $this->input->post('status'),
			'sort' => $this->input->post('sort'),
			'groupId' => intval($this->input->post('groupId')),
			'level' => $this->input->post('level'),
			'type' => $this->input->post('type'),
			'updateTime' => $currentTime,
			'updateUid' => 1,
		);
		$result = $this->role_model->update(array('id'=>$id), $data);
		$res['message'] = $result ? '保存成功' : '保存失败';
		$result && $res['success'] = 1;
		$result && $res['reload'] = 1;
		echo json_encode($res);
	}

}