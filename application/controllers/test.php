<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-7-29
 * Time: 下午3:40
 */

class Test extends Home_Controller
{

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model(
            array('test_model')
        );
    }

    /**
     * 用户列表
     */
    public function index()
    {
        $defaultStartDate = date('Y-m-d', mktime(date('H'), date('i'), date('s'), date('n')-3));
        $defaultEndDate   = date('Y-m-d');
        if (!is_ajax())
        {
            parent::set_html_header();
            $assign['dataGridUrl'] = '/test/index';
            $assign['defaultStartDate'] = $defaultStartDate;
            $assign['defaultEndDate'] = $defaultEndDate;
            $this->smarty->view('home/test/index.tpl', $assign);
            return;
        }
        $map = array();
        $sort = I('get.sort', 'id', 'trim');
        $order = I('get.order', 'asc', 'trim');
        $sort && $order && $map['order_by'] = array($sort, $order);

        $startDate = strtotime(I('get.startDate', $defaultStartDate, 'trim'));
        $endDate = strtotime(I('get.endDate', $defaultEndDate, 'trim'));
        $map[] = 'createTime between '.$startDate.' AND '. $endDate;

        $status = I('get.status', 0, 'intval');
        $status != '' && $map[] = array('status'=>intval($status));
        $title = I('get.title', '', 'strip_tags,trim');
        $title != '' && $map[] = 'title LIKE "'.$title.'%"';

        $page = I('get.page', 1, 'intval');
        $rows = I('get.rows', config_item('pageSize'), 'intval');
        $map['limit'] = array($rows, ($page?$page-1:0)*$rows);
        $list = $this->test_model->get_list($map, 'id,title,body,status,createTime');
        foreach ( $list['rows'] as $key => $row ) {
            $list['rows'][$key]['date'] = date('Y-m-d', $row['createTime']);
        }
        echo json_encode($list);
    }

    /**
     * 创建
     */
    public function create()
    {
        $assign['page_title'] = '创建用户';
        if  (!is_post()) {
            $this->smarty->view('home/user/create.tpl', $assign);
            return;
        }
        $data['uName'] = I('post.uName', '', 'strip_tags,trim');
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
        $data['node_group_list'] = config_item('node_group');
        $data['data'] = $this->node_model->get_row($id);
        if (!is_post())
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

    /**
     * @param $id
     */
    public function set_role($id){
        $id = intval($id);
        if (!is_post())
        {
            $this->load->model('role_user_model');
            parent::set_html_header();
            //已选中角色
            $assign['roleUsers']         = $this->role_user_model->get_list(array('userId'=>$id), 'roleId');
            $roleIds = '';
            $rows = $assign['roleUsers']['rows'];
            foreach($rows as $row) {
                $roleIds .= $roleIds !== ''  ?  ','.$row['roleId'] : $row['roleId'];
            }
            $assign['roleIds'] = $roleIds;
            $assign['searchBlockHeight'] = 42;
            $assign['userId']            = $id;
            $assign['dataGridUrl']     = config_item('base_url') . 'role/index';

            $this->smarty->view('home/user/set_role.tpl', $assign);
            return;
        }
        $data['groupList']   = config_item('role_group');
        $data['editable']    = 0;
        $data['searchBlockHeight'] = 42;
        $data['editHandler'] = 'role.editHandler';
        $roleIds = array_filter(explode(',', I('post.roles', '', 'strip_tags,trim')));
        $this->load->model('role_user_model');
        $roleUsers = array();
        foreach($roleIds as $roleId) {
            $roleUsers[] = array(
                'roleId' => $roleId,
                'userId' => $id
            );
        }
        $this->role_user_model->delete(array('userId'=>$id));
        $result = $this->role_user_model->batch_insert($roleUsers);
        $result OR ajax_exit('保存失败');
        echo json_encode(
            array(
                'message' => '保存成功',
                'success' => 1
            )
        );
    }

    /**
     * 删除
     */
    public function remove()
    {
        if (!is_post()) {
            return;
        }
        $ids     = I('post.ids', '', 'strip_tags,trim');
        regex($ids, 'require') OR ajax_exit('请选择要删除的行！');
        $result = $this->test_model->delete('id in('.$ids.')');
        $res = array(
            'reloadType' => 2,
            'message'    => $result  !== false  ? '操作成功' : '操作失败',
            'success'    => $result  !== false  ? 1 : 0,
        );
        echo_json($res);
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
        $result = $this->set_status('id in('.$ids.')', 0);
        $res = array(
            'message' => $result  !== false  ? '操作成功' : '操作失败',
            'reloadType' => 2,
            'success' => $result  !== false  ? 1 : 0,
        );
        echo_json($res);
    }

    /**
     * 启用
     */
    public function enable()
    {
        if (!is_ajax()) {
            return;
        }
        $ids = $this->input->post('ids');
        regex($ids, 'require') OR ajax_exit('请选择要启用的行!');
        $result = $this->set_status('id in('.$ids.')', 1);
        $res = array(
            'message' => $result  !== false ? '操作成功' : '操作失败',
            'reloadType' => 2,
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
        return $this->test_model->update($where, array('status'=>$status));
    }

}

/* End of file user.php */
/* Location: ./application/controllers/user.php */
