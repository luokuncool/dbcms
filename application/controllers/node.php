<?php
class Node extends HOME_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(
			array('node_model')
		);
	}

	/**
	 * 节点列表
	 */
	public function index()
	{
		$data['groupList']     = $this->config->config['node_group'];
		$data['editable']        = 0;
		$data['editHandler']  = 'Node.editHandler';
		if  (!IS_AJAX) {
			parent::set_html_header();
			$data['page_title'] = '前台首页';
			$data['data_grid_url'] = '/node/index';
			$this->smarty->view('home/node/index.tpl', $data);
			return;
		}

		$map = array();
		$sort = $this->input->get('sort');
		$order = $this->input->get('order');
		$map['order_by'] = ($sort && $order) ? array($sort, $order) : array('code', 'asc');

		$code = $this->input->get('code');
		$code && $map[] = 'code LIKE "%'.$code.'%"';

		$status = $this->input->get('status');
		$status != '' && $map[] = array('status'=>intval($status));
		$name = $this->input->get('name');
		$name != '' && $map[] = 'name LIKE "%'.$name.'%"';

		$page = intval($this->input->get('page'));
		$rows = intval($this->input->get('rows'));
		$map['limit'] = array($rows, ($page ? $page-1 : 0)*$rows);

		$field = $this->node_model->table.'.*, '.'(select name form '.$this->db->dbprefix.$this->node_model->table.' pTable where pTable.id='.$this->node_model->table.'.pId)';
		$list = $this->node_model->get_list($map);
		$list['sql'] = $this->node_model->last_query();
		$list['map'] = $map;
		foreach ($list['rows'] as $key=>$value) {
			//$list['rows'][$key]['opt'] = '<a class="easyui-linkbutton icon-add" data-options="iconCls:\'icon-add\'" href="javascript:parent.App.addTab(\'添加节点\', \'/node/create\');" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">&nbsp;</a>';
		}
		echo json_encode($list);
	}

	/**
	 * 创建节点
	 */
	public function create()
	{
		$pId                                     = intval($this->input->get('pId'));
		$data['pId']                         = $pId;
		$data['node_group_list'] = $this->config->config['node_group'];
		if  (!$_POST) {
			$this->smarty->view('home/node/create.tpl', $data);
			return;
		}
		$code  = $this->input->post('code');
		$name = $this->input->post('name');
		$currentTime = time();
		regex($code, 'require')  OR exit('{"message":"请填写操作代码！"}');
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
		$id = $this->node_model->insert($data);
		$res['message'] = $id ? '添加成功' : '添加失败';
		$id && $res['closeSelf'] = 1;
		$id && $res['success'] = 1;
		echo json_encode($res);
	}

	/**
	 * 修改节点
	 */
	public function edit($id)
	{
		$id = intval($id);
		$data['node_group_list'] = $this->config->config['node_group'];
		$data['data'] = $this->node_model->get_row($id);
		if (!$_POST)
		{
			$this->smarty->view('home/node/edit.tpl', $data);
			return;
		}
		$code = $this->input->post('code');
		$name = $this->input->post('name');
		$currentTime = time();
		regex($code, 'require')  OR exit('{"message":"请填写操作代码！"}');
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
		$result = $this->node_model->update(array('id'=>$id), $data);
		$res['message'] = $result ? '保存成功' : '保存失败';
		$id && $res['closeSelf'] = 1;
		$id && $res['success'] = 1;
		echo json_encode($res);
	}

}