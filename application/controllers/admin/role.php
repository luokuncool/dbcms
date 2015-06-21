<?php

class Role extends Admin_Controller
{

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
        parent::set_html_header();
        $data['groupList'] = config_item('role_group');
        $data['editable'] = 0;
        $data['searchBlockHeight'] = 42;
        $data['editHandler'] = 'role.editHandler';
        $map = array();
        $name = I('get.name', '', 'strip_tags,trim');
        $name != '' && $map[] = 'name LIKE "%' . $name . '%"';

        $status = I('get.status', '', 'strip_tags,trim');
        $status != '' && $map[] = array('status' => intval($status));

        $sort = I('get.sort', 'id', 'strip_tags,trim');
        $order = I('get.order', 'desc', 'strip_tags,trim');
        $map['order_by'] = array($sort, $order);

        $page = I('get.page', '1', 'intval');
        $pageSetting = config_item('pageSetting');
        $rows = I('get.rows', $pageSetting['pageSize'], 'intval');
        $map['limit'] = array($rows, ($page - 1) * $rows);

        $list = $this->role_model->get_list($map, 'id,name,status,remark,createTime');
        foreach ($list['rows'] as $key => $value) {
            //$list['rows'][$key]['opt'] = '<a class="easyui-linkbutton icon-add" data-options="iconCls:\'icon-add\'" href="javascript:parent.App.addTab(\'添加节点\', \'/role/create\');" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">&nbsp;</a>';
        }
        $data['list'] = $list;
        $data['pagination'] = array('page' => $page, 'total' => $list['total'], 'rows' => $rows);
        $this->smarty->view('admin/role/index.tpl', $data);
    }

    /**
     * 创建节点
     */
    public function create()
    {
        if (!is_post()) {
            $data['role_group_list'] = config_item('role_group');
            $data['data'] = $this->role_model->get_row();
            $this->smarty->view('admin/role/create.tpl', $data);
            return;
        }
        $name = I('post.name', '', 'strip_tags,trim');
        regex($name, 'require') OR ajax_exit('请填写角色名！');
        $exist = $this->role_model->check_name($name);
        $exist && ajax_exit('角色名已经存在！');

        $currentTime = time();
        $data = array(
            'name' => $name,
            'status' => I('post.status', '', 'intval'),
            'remark' => I('post.remark', '', 'strip_tags,trim'),
            'updateTime' => $currentTime,
            'updateUid' => 1,
        );
        $id = $this->role_model->insert($data);
        $id === false && ajax_exit('操作失败');
        $res = array(
            'message' => '操作成功',
            'closeSelf' => 1,
            'success' => 1,
            'reloadType' => 'reloadGrid',
        );
        echo_json($res);
    }

    /**
     * 修改节点
     *
     * @param $id
     */
    public function edit($id)
    {
        $id = intval($id);
        if (!is_post()) {
            $data['role_group_list'] = config_item('role_group');
            $data['data'] = $this->role_model->get_row($id);
            $this->smarty->view('admin/role/edit.tpl', $data);
            return;
        }
        $name = I('post.name', '', 'strip_tags,trim');
        regex($name, 'require') OR ajax_exit('请填写角色名！');
        $exist = $this->role_model->check_name($name . ' AND id<>' . $id);
        $exist && ajax_exit('角色名已经存在！');

        $currentTime = time();
        $data = array(
            'name' => $name,
            'status' => I('post.status', '', 'intval'),
            'remark' => I('post.remark', '', 'strip_tags,trim'),
            'updateTime' => $currentTime,
            'updateUid' => 1,
        );
        $result = $this->role_model->update(array('id' => $id), $data);
        $result === false && ajax_exit('操作失败');
        $res = array(
            'message' => '操作成功',
            'closeSelf' => 1,
            'success' => 1,
            'reloadType' => 'reloadGrid',
        );
        echo_json($res);
    }

    /**
     * 禁用角色
     */
    public function disable()
    {
        if (!is_post()) {
            return;
        }
        $roleIds = I('post.ids', '', 'strip_tags,trim');
        regex($roleIds, 'require') OR ajax_exit('请选择角色!');
        $result = $this->set_status('id in(' . $roleIds . ')', 0);
        $result === false && ajax_exit('操作失败');
        $res = array(
            'message' => '操作成功',
            'success' => 1,
            'reloadType' => 'reloadGrid',
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
        $result = $this->set_status('id in(' . $roleIds . ')', 1);
        $result === false && ajax_exit('操作失败');
        $res = array(
            'message' => '操作成功',
            'success' => 1,
            'reloadType' => 'reloadGrid',
        );
        echo_json($res);
    }

    /**
     * 设置角色用户
     *
     * @param $id
     */
    public function set_user($id)
    {
        $id = intval($id);
        if (!is_post()) {
            $this->load->model('role_user_model');
            parent::set_html_header();
            //已选中角色
            $assign['roleUsers'] = $this->role_user_model->get_list(array('roleId' => $id), 'userId');
            $userIds = '';
            $rows = $assign['roleUsers']['rows'];
            foreach ($rows as $row) {
                $userIds .= $userIds !== '' ? ',' . $row['userId'] : $row['userId'];
            }
            $assign['userIds'] = $userIds;
            $assign['roleId'] = $id;
            $assign['dataGridUrl'] = config_item('base_url') . 'admin/user/index';
            $this->smarty->view('admin/role/set_user.tpl', $assign);
            return;
        }
        $usersId = array_filter(explode(',', I('post.users', '', 'strip_tags,trim')));
        $this->load->model('role_user_model');
        $roleUsers = array();
        foreach ($usersId as $userId) {
            $roleUsers[] = array(
                'roleId' => $id,
                'userId' => $userId
            );
        }
        $this->role_user_model->delete(array('roleId' => $id));
        if ($usersId) {
            $result = $this->role_user_model->batch_insert($roleUsers);
            $result OR ajax_exit('保存失败');
        }
        echo json_encode(
            array(
                'message' => '保存成功',
                'reloadType' => 'reloadGrid',
                'success' => 1
            )
        );
    }

    /**
     * toCheck 设置权限
     *
     * @param $id
     */
    public function set_rights($id)
    {
        $this->load->model(array('node_model', 'role_node_model'));
        if (!is_ajax()) {
            parent::set_html_header();
            $existsNodeIds = $this->role_node_model->get_list(array('roleId' => $id), 'nodeId');
            $assign['roleId'] = $id;
            $assign['groupList'] = config_item('node_group');
            $assign['data'] = $this->role_model->get_row($id);
            $assign['nodeIds'] = explode(',', get_field_list($existsNodeIds['rows'], 'nodeId'));
            $assign['moduleTree'] = $this->node_model->getNodeTree();
            $this->smarty->view('admin/role/set_rights.tpl', $assign);
            return;
        }

        if (is_post()) {
            $nodeIds = $this->input->post('nodeIds');
            $nodeIds = array_keys($nodeIds);
            $nodeRights = array();
            foreach ($nodeIds as $nodeId) {
                $nodeRights[] = array(
                    'roleId' => $id,
                    'nodeId' => $nodeId
                );
            }
            $this->role_node_model->delete(array('roleId' => $id));
            if ($nodeRights) {
                $result = $this->role_node_model->batch_insert($nodeRights);
                $result OR ajax_exit('保存失败');
            }
            echo json_encode(
                array(
                    'message' => '保存成功',
                    'reloadType' => 'reloadGrid',
                    'success' => 1
                )
            );
            return;
        }

        $map = array();
        $map[] = array('level' => 2);
        $sort = I('get.sort', 'code', 'strip_tags,trim');
        $order = I('get.order', 'asc', 'strip_tags,trim');
        $map['order_by'] = array($sort, $order);

        $code = I('get.code', '', 'strip_tags,trim');
        $code && $map[] = 'code LIKE "%' . $code . '%"';

        $status = I('get.status', '', 'strip_tags,trim');
        $status != '' && $map[] = array('status' => intval($status));
        $name = I('get.name', '', 'strip_tags,trim');
        $name != '' && $map[] = 'name LIKE "%' . $name . '%"';

        $page = I('get.page', '1', 'intval');
        $rows = I('get.rows', config_item('pageSize'), 'intval');
        $map['limit'] = array($rows, ($page - 1) * $rows);

        $res = $this->node_model->get_list($map, 'id,name,code,status,level,type,sort,pId,groupId');
        foreach ($res['rows'] as $key => $value) {
            $pNode = $this->node_model->get_row($value['pId']);
            $res['rows'][$key]['pNodeName'] = $pNode['name'];
        }
        echo_json($res);
    }

    /**
     * 删除
     * @author Quentin
     * @since  2014-12-06 02:29
     *
     * @access public
     * @return void
     */
    public function remove()
    {
        if (!is_post()) {
            ajax_exit('请选中要删除的行！');
        }
        $ids = I('post.ids', '', 'strip_tags,trim');
        regex($ids, 'require') OR ajax_exit('请选择要删除的行！');
        $result = $this->role_model->delete('id in(' . $ids . ')');
        $res = array(
            'reloadType' => 'reloadGrid',
            'message' => $result !== false ? '操作成功' : '操作失败',
            'success' => $result !== false ? 1 : 0,
        );
        echo_json($res);
    }

    /**
     * 设置角色状态
     *
     * @param $where
     * @param $status
     *
     * @return mixed
     */
    private function set_status($where, $status)
    {
        return $this->role_model->update($where, array('status' => $status));
    }

}

/* End of file role.php */
/* Location: ./application/controllers/role.php */
