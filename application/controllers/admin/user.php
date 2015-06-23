<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-7-29
 * Time: 下午3:40
 */

class User extends Admin_Controller
{

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model(
            array('user_model')
        );
    }

    /**
     * 用户列表
     */
    public function index()
    {
        $map = array('id >' => 0);
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');
        $sort && $order && $map['order_by'] = array($sort, $order);

        $uName = $this->input->get('uName');
        $uName && $map[] = 'uName LIKE "%'.$uName.'%"';

        $status = $this->input->get('status');
        $status != '' && $map[] = array('status'=>intval($status));
        $name = $this->input->get('name');
        $name != '' && $map[] = 'name LIKE "%'.$name.'%"';

        $page = I('get.page', '1', 'intval');
        $pageSetting = config_item('pageSetting');
        $rows = I('get.rows', $pageSetting['pageSize'], 'intval');
        $map['limit'] = array($rows, ($page ? $page-1 : 0)*$rows);
        $list = $this->user_model->get_list($map, 'id,uName,code,name,enName,email,mobile,userType,lastLoginTime,status,createTime');
        $data['list'] = $list;
        $data['pagination'] = array('page'=>$page, 'total'=>$list['total'], 'rows'=>$rows);
        $this->smarty->view('admin/user/index.tpl', $data);
    }

    /**
     * 创建
     */
    public function create()
    {
        $assign['page_title'] = '创建用户';
        if  (!is_post()) {
            $this->smarty->view('admin/user/create.tpl', $assign);
            return;
        }
        $data['uName'] = I('post.uName', '', 'strip_tags,trim');
		regex($data['uName'], 'require') OR ajax_exit('请输入登录名!');
		$this->user_model->exists(array('uName'=>$data['uName'])) && ajax_exit('该用户已经存在!');

		$data['password'] = I('post.password', '', 'trim');
		regex($data['password'], 'require') OR ajax_exit('请输入登陆密码!');
		$rePassword = I('post.rePassword', '', 'trim');
		$rePassword == $data['password'] OR ajax_exit('两次密码输入不一致!');
		$data['password'] = md5($data['password']);

		$data['name'] = I('post.name', '', 'trim,strip_tags');
		regex($data['name'], 'require') OR ajax_exit('请输入用户名!');

		$data['status'] = I('post.status', 0, 'intval');
		$data['email'] = I('post.email', '', 'trim,strip_tags');
		$data['createUid'] = get_uid();
		$data['createTime'] = time();
        $id = $this->node_model->insert($data);
        $res['message'] = $id ? '添加成功' : '添加失败';
        $id && $res['closeSelf'] = 1;
        $id && $res['success'] = 1;
        echo json_encode($res);
    }

    /**
     * 修改
     * @param $id
     */
    public function edit($id)
    {
        $id = intval($id);
        $assign['node_group_list'] = config_item('node_group');
        $assign['data'] = $this->user_model->get_row($id);
        if (!is_post())
        {
            $this->smarty->view('admin/user/edit.tpl', $assign);
            return;
        }
		$data['uName'] = I('post.uName', '', 'strip_tags,trim');
		regex($data['uName'], 'require') OR ajax_exit('请输入登录名!');
		if ($assign['data']['uName'] != $data['uName'] &&
			$this->user_model->exists(array('uName' => $data['uName']))
		) {
			ajax_exit('该用户已经存在!');
		}

		if ($data['password'] != '') {
			$data['password'] = I('post.password', '', 'trim');
			regex($data['password'], 'require') OR ajax_exit('请输入登陆密码!');
			$rePassword = I('post.rePassword', '', 'trim');
			$rePassword == $data['password'] OR ajax_exit('两次密码输入不一致!');
			$data['password'] = md5($data['password']);
		}

		$data['name'] = I('post.name', '', 'trim,strip_tags');
		regex($data['name'], 'require') OR ajax_exit('请输入用户名!');

		$data['status'] = I('post.status', 0, 'intval');
		$data['email'] = I('post.email', '', 'trim,strip_tags');
        $result = $this->user_model->update(array('id'=>$id), $data);
        $res['message'] = $result ? '保存成功' : '保存失败';
        echo json_encode($res);
    }

    /**
     * @param $id
     */
    public function set_role($id){
        $id = intval($id);
        if (!is_ajax())
        {
            $this->load->model(array('role_user_model', 'role_model'));
            parent::set_html_header();
            //已选中角色
            $assign['roleUsers']         = $this->role_user_model->get_list(array('userId'=>$id), 'roleId');
            $roleIds = array();
            $rows = $assign['roleUsers']['rows'];
            foreach($rows as $row) {
                array_push($roleIds, $row['roleId']);
            }
            $assign['roleIds'] = $roleIds;
            $assign['userId']            = $id;
            $list = $this->role_model->get_list();
            $assign['list'] = $list;

            $this->smarty->view('admin/user/set_role.tpl', $assign);
            return;
        }
        $roleIds = $this->input->post('roles');
        $roleIds = array_keys($roleIds);
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
		$ids = I('ids', '', 'trim,strip_tags');
		$this->user_model->delete('id in(' . $ids . ')');
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
        $result = $this->set_status('id in('.$ids.')', 0);
        $res = array(
            'message' => $result  !== false  ? '操作成功' : '操作失败',
            'reloadType' => 'reloadGrid',
            'success' => $result  !== false  ? 1 : 0,
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
        $ids = $this->input->post('ids');
        regex($ids, 'require') OR ajax_exit('请选择要启用的行!');
        $result = $this->set_status('id in('.$ids.')', 1);
        $res = array(
            'message' => $result  !== false ? '操作成功' : '操作失败',
            'reloadType' => 'reloadGrid',
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
        return $this->user_model->update($where, array('status'=>$status));
    }

}

/* End of file user.php */
/* Location: ./application/controllers/user.php */