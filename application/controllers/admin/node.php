<?php

class Node extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(
            array('node_model')
        );
    }

    /**
     * 列表
     */
    public function index()
    {
		$this->output->enable_profiler(true);
		$map = array();
        $sort = I('get.sort', 'code', 'strip_tags,trim');
        $order = I('get.order', 'asc', 'strip_tags,trim');
        $map['order_by'] = array($sort, $order);

        $code = I('get.code', '', 'strip_tags,trim');
        $code && $map[] = 'code LIKE "%' . $code . '%"';

        $status = I('get.status', '', 'strip_tags,trim');
        $status != '' && $map[] = array('status' => intval($status));
        $name = I('get.name', '', 'strip_tags,trim');
        $name != '' && $map[] = 'name LIKE "%' . $name . '%"';

        $res = $this->node_model->get_list($map, 'id,name,code,status,level,type,sort,pId,groupId,module');
		$nodeGroup = config_item('node_group');
        foreach ($res['rows'] as $key => $value) {
			$res['rows'][$key]['menuName'] = $nodeGroup[$value['groupId']]['groupName'];
        }
		$this->node_model->getModules();
		$assign['nodes'] = $res['rows'];
		$this->smarty->view('admin/node/index.tpl', $assign);
    }

    /**
     * 创建
     */
    public function create()
    {
        if (!is_post()) {
            $assign['node_group_list'] = config_item('node_group');
            $assign['modules'] = $this->node_model->getModules();
            $this->smarty->view('admin/node/create.tpl', $assign);
            return;
        }

        $data = $this->validation();
        $id = $this->node_model->insert($data);
        $id OR ajax_exit('添加失败');

        $res['message'] = '添加成功';
        $res['closeSelf'] = 1;
        $res['success'] = 1;
        $res['reloadType'] = 'reloadGrid';
        echo_json($res);
    }

    /**
     * 修改
     *
	 * @param $id
     */
    public function edit($id)
    {
        $id = intval($id);
        if (!is_post()) {
            $data['node_group_list'] = config_item('node_group');
            $data['data'] = $this->node_model->get_row($id);
			$data['modules'] = $this->node_model->getModules();
			$this->smarty->view('admin/node/edit.tpl', $data);
            return;
        }
        $data = $this->validation($id);
        $result = $this->node_model->update(array('id' => $id), $data);
        $res['message'] = $result ? '保存成功' : '保存失败';
        $id && $res['success'] = 1;
        $id && $res['closeSelf'] = 1;
        $id && $res['reloadType'] = 2;
        $res['reloadType'] = 'reloadGrid';
        echo json_encode($res);
    }

    /**
     * 创建操作
     *
     * @param $pId
     */
    public function create_method($pId)
    {
        $assign['group'] = $this->node_model->get_row($pId, 'code');
        $assign['node_group_list'] = config_item('node_group');
        if (!is_post()) {
            $this->smarty->view('admin/node/create.tpl', $assign);
            return;
        }
        $data = $this->validation(0, $pId, 2);
        $result = $this->node_model->insert($data);
        $res['message'] = $result ? '保存成功' : '保存失败';
        $result && $res['closeSelf'] = 1;
        $result && $res['success'] = 1;
        $res['reloadType'] = 'reloadGrid';
        echo json_encode($res);
    }

    /**
     * 删除
     */
    public function remove()
    {
        $ids = I('ids', '', 'trim,strip_tags');
        regex($ids, 'require') OR ajax_exit('请选择要删除的行！');
        $this->node_model->delete('id in(' . $ids . ')');
        parent::jump('操作成功', '/admin/node/index');
    }

    /**
     * 禁用
     */
    public function disable()
    {
        if (!is_post()) {
            return;
        }
        $ids = $this->input->post('ids');
        regex($ids, 'require') OR ajax_exit('请选择要禁用的行！');
        $result = $this->set_status('id in(' . $ids . ')', 0);
        $res = array(
            'message' => $result !== false ? '操作成功' : '操作失败',
            'success' => $result !== false ? 1 : 0,
            'reloadType' => 'reloadGrid'
        );
        echo_json($res);
    }

    /**
     * 启用
     */
    public function enable()
    {
        if (!is_post()) {
            return;
        }
        $ids = I('post.ids', '', 'strip_tags,trim');
        regex($ids, 'require') OR ajax_exit('请选择要启用的行!');
        $result = $this->set_status('id in(' . $ids . ')', 1);
        $res = array(
            'message' => $result !== false ? '操作成功' : '操作失败',
            'success' => $result !== false ? 1 : 0,
            'reloadType' => 'reloadGrid'
        );
        echo_json($res);
    }

    /**
     * 设置状态
     *
     * @param $where
     * @param $status
     *
     * @return mixed
     */
    private function set_status($where, $status)
    {
        return $this->node_model->update($where, array('status' => $status));
    }

    /**
     * 增删验证
     *
     * @param int $id
     *
     * @return array
     */
    private function validation($id = 0)
    {
        $code = I('post.code', '', 'trim,strip_tags');
		$name = I('post.name', '', 'trim,strip_tags');
		$module = I('post.module', '', 'trim,strip_tags');
        $currentTime = time();
        regex($code, 'require') OR ajax_exit('请填写节点代码');
        $existCode = $this->node_model->check_code($id ? $code . ' AND id<>' . $id : $code);
        $existCode && ajax_exit('节点代码已经存在！');
		regex($name, 'require') OR ajax_exit('请填写显示名');
		regex($module, 'require') OR ajax_exit('请选择所属模块');
        $existName = $this->node_model->check_code($id ? $name . ' AND id<>' . $id : $name);
        $existName && ajax_exit('显示名已经存在！');
        $data = array(
            'code' => $code,
            'name' => $name,
            'status' => I('post.status', '', 'intval'),
            'remark' => I('post.remark', '', 'htmlspecialchars'),
            'sort' => I('post.sort', 0, 'intval'),
            'groupId' => I('post.groupId', 0, 'intval'),
			'level' => 1,
            'isMenu' => I('post.isMenu', 0, 'intval'),
            'iconCls' => I('post.iconCls', 'fa-circle-o', 'trim,strip_tags'),
			'module' => $module,
            'type' => I('post.type', 0, 'intval'),
            'updateTime' => $currentTime,
            'updateUid' => get_uid(),
        );
        $id OR $data['createTime'] = $currentTime;
        $id OR $data['createUid'] = get_uid();
        return $data;
    }

}

/* End of file node.php */
/* Location: ./application/controllers/node.php */
