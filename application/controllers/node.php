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
	 * 列表 /usr/bin/X11/php-config
	 */
	public function index()
	{
		$data['groupList']     = $this->config->config['node_group'];
		$data['editable']        = 0;
		//$data['searchBlockHeight'] = 42;
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
		$list = $this->node_model->get_list($map, 'id,status');
		$list['sql'] = $this->node_model->last_query();
		$list['map'] = $map;
		foreach ($list['rows'] as $key=>$value) {
			//$list['rows'][$key]['opt'] = '<a class="easyui-linkbutton icon-add" data-options="iconCls:\'icon-add\'" href="javascript:parent.App.addTab(\'添加节点\', \'/node/create\');" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">&nbsp;</a>';
		}
		echo json_encode($list);
	}

	/**
	 * 创建
	 * @param $pId
	 */
	public function create($pId)
	{
		$pId                          = intval($pId);
		$assign['pId']           = $pId;
		$assign['page_title'] = '创建节点';
		if  (!$_POST) {
			$this->smarty->view('home/node/create.tpl', $assign);
			return;
		}
		$data = $this->validation(0, $pId);
		$id = $this->node_model->insert($data);
		$res['message'] = $id ? '添加成功' : '添加失败';
		$id && $res['closeSelf'] = 1;
		$id && $res['success'] = 1;
		echo json_encode($res);
	}

	/**
	 * 修改
	 * @param $id
	 * @param $pId
	 * @param $level
	 */
	public function edit($id, $pId, $level)
	{
		$id = intval($id);
		$data['node_group_list'] = $this->config->config['node_group'];
		$data['data'] = $this->node_model->get_row($id);
		if (!$_POST)
		{
			$this->smarty->view('home/node/edit.tpl', $data);
			return;
		}
		$data = $this->validation($id, $pId, $level);
		$result = $this->node_model->update(array('id'=>$id), $data);
		$res['message'] = $result ? '保存成功' : '保存失败';
		$id && $res['closeSelf'] = 1;
		$id && $res['success'] = 1;
		echo json_encode($res);
	}

	public function create_method($pId){
		$data['node_group_list'] = $this->config->config['node_group'];
		$data['page_titlee'] = '添加操作';
		if (!$_POST)
		{
			$this->smarty->view('home/node/edit.tpl', $data);
			return;
		}
		$data = $this->validation(0, $pId, 2);
		$result = $this->node_model->insert($data);
		$res['message'] = $result ? '保存成功' : '保存失败';
		$result && $res['closeSelf'] = 1;
		$result && $res['success'] = 1;
		echo json_encode($res);
	}

	/**
	 * 删除
	 */
	public function remove()
	{
		if (!$_POST) {
			return;
		}
		$ids = $this->input->post('ids');
		regex($ids, 'require') OR ajax_exit('请选择要删除的行！');
		$result = $this->node_model->delete(array('id in('.$ids.')'));
		$res = array(
			'message' => $result  !== false  ? '操作成功' : '操作失败',
			'success' => $result  !== false  ? 1 : 0,
		);
		echo_json($res);
	}

	/**
	 * 禁用
	 */
	public function disable()
	{
		if (!$_POST) {
			return;
		}
		$ids = $this->input->post('ids');
		regex($ids, 'require') OR ajax_exit('请选择要禁用的行！');
		$result = $this->set_status('id in('.$ids.')', 0);
		$res = array(
			'message' => $result  !== false  ? '操作成功' : '操作失败',
			'success' => $result  !== false  ? 1 : 0,
		);
		echo_json($res);
	}

	/**
	 * 启用
	 */
	public function enable()
	{
		if (!$_POST) {
			return;
		}
		$ids = $this->input->post('ids');
		regex($ids, 'require') OR ajax_exit('请选择要启用的行!');
		$result = $this->set_status('id in('.$ids.')', 1);
		$res = array(
			'message' => $result  !== false ? '操作成功' : '操作失败',
			'success' => $result  !== false  ? 1 : 0,
		);
		echo_json($res);
	}

	/**
	 * 设置状态
	 * @param $where
	 * @param $status
	 * @return mixed
	 */
	private function set_status($where, $status) {
		return $this->node_model->update($where, array('status'=>$status));
	}

	/**
	 * 增删验证
	 * @param int $id
	 * @param int $pId
	 * @param int $level
	 * @return array
	 */
	private function validation($id=0, $pId=0, $level=1){
		$code = I('post.code', '', 'strip_tags');
		$name = I('post.name', '', 'strip_tags');
		$currentTime = time();
		regex($code, 'require')  OR ajax_exit('请填写节点代码');
		$existCode = $this->node_model->check_code($id ? $code.' AND id<>'.$id : $code);
		$existCode && ajax_exit('节点代码已经存在！');
		regex($name, 'require') OR ajax_exit('请填写显示名');
		$existName = $this->node_model->check_code($id ? $name.' AND id<>'.$id : $name);
		$existName && ajax_exit('显示名已经存在！');
		$data = array(
			'code' => $code,
			'name' => $name,
			'status' => I('post.status', '', 'intval'), //intval($this->input->post('status')),
			'remark' => I('post.remark', '', 'htmlspecialchars'), //$this->input->post('status'),
			'sort' => I('post.sort', 0, 'intval'), //$this->input->post('sort'),
			'groupId' => I('post.groupId', 0, 'intval'), //intval($this->input->post('groupId')),
			'level' => $level, //$this->input->post('level'),
			'type' => I('post.type', 0, 'intval'), //$this->input->post('type'),
			'updateTime' => $currentTime,
			'updateUid' => 1,
		);
		$id OR $data['createTime'] = $currentTime;
		$id OR $data['createUid'] = '1';
		$pId && $data['pId'] = $pId;
		return $data;
	}

}