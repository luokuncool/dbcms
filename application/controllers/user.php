<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-7-29
 * Time: 下午3:40
 */

class User extends Home_Controller
{

	/**
	 * 构造函数
	 */
	public function __construct()
	{
		parent::__construct();

	}

	/**
	 * 管理组列表
	 */
	public function group_list()
	{
		parent::set_html_header();
		$where = array();
		$keyword = deep_htmlspecialchars($_GET['s']);
		$keyword == '1' || $where[] = 'INSTR(group_name, "'.$keyword.'")>0';
		$where = join(' AND ', $where);
		$data['group_list'] = $this->admin_model->get_admin_group_list($where);
		$this->smarty->view('admin/admin/group_list.tpl', $data);
	}

	/**
	 * 添加管理组
	 */
	public function add_group()
	{
		if ($_POST)
		{
			parent::set_json_header();
			$this->load->library('form_validation');
			$this->load->helper('array_helper');
			$POST = deep_htmlspecialchars($_POST);
			$this->form_validation->required($POST['group_name']) OR exit('{"message":"请填写分组名称！", "selector":"[name=group_name]"}');
			$POST['purview_key'] = serialize($POST['purview_key']);
			$data = elements(array('group_name', 'purview_key', 'intro'), $POST);
			$this->admin_model->add_admin_group($data);
			echo '{"success":1, "message":"操作成功！", "redirect":"'.urldecode($_GET['redirect']).'"}';
		}
		else
		{
			parent::set_html_header();
			$data['purview_group_list'] = $this->admin_router_model->get_purview_group_list();
			$this->smarty->view('admin/admin/add_group.tpl', $data);
		}
	}

	/**
	 * 删除管理组
	 */
	public function delete_group()
	{
		parent::set_json_header();
		if ($_POST) {
			$id_list = join(',', $_POST['id']);
			if ($id_list)
			{
				$this->admin_model->update_admin('group_id in('.$id_list.')', array('group_id'=>'-1'));
				$this->admin_model->delete_admin_group('id in('.$id_list.')');
			}
			echo '{"success":1, "message":"操作成功！", "redirect":"'.urldecode($_GET['redirect']).'"}';
		} else {
			redirect('/admin/group_list');
		}
	}

	/**
	 * 编辑管理组
	 * @param $id
	 */
	public function edit_group($id)
	{
		if ($_POST)
		{
			parent::set_json_header();
			$this->load->library('form_validation');
			$this->load->helper('array_helper');
			$POST = deep_htmlspecialchars($_POST);
			$this->form_validation->required($POST['group_name']) OR exit('{"message":"请填写分组名称！", "selector":"[name=group_name]"}');
			$POST['purview_key'] = serialize($POST['purview_key']);
			$data = elements(array('group_name', 'purview_key', 'intro'), $POST);
			$this->admin_model->update_admin_group(array('id'=>$id),$data);
			echo '{"success":1, "message":"操作成功！", "redirect":"'.urldecode($_GET['redirect']).'"}';
		}
		else
		{
			parent::set_html_header();
			$data['purview_group_list'] = $this->admin_router_model->get_purview_group_list();
			$data['data'] = $this->admin_model->get_group($id);
			$this->smarty->view('admin/admin/add_group.tpl', $data);
		}
	}

	/**
	 * 管理员列表
	 */
	public function admin_list()
	{
		parent::set_html_header();
		$where = array();
		$keyword = deep_htmlspecialchars($_GET['s']);
		$keyword == '1' || $where[] = 'INSTR(login_name, "'.$keyword.'")>0 OR INSTR(real_name, "'.$keyword.'")>0';
		$where = join(' AND ', $where);
		$data['admin_list'] = $this->admin_model->get_admin_list($where);
		$this->smarty->view('admin/admin/admin_list.tpl', $data);
	}

	/**
	 * 添加管理员
	 */
	public function create()
	{
		if ($_POST)
		{
            echo json_encode(array('a')); exit();
			//parent::set_json_header();
			$this->load->library('form_validation');
			$this->load->helper('array_helper');
			$POST = deep_htmlspecialchars($_POST);
			//登录名
			$this->form_validation->required($POST['login_name']) OR exit('{"message":"登录名不能为空！", "selector":"[name=login_name]"}');
			$exists = $this->admin_model->exists(array('login_name'=>$POST['login_name']), $this->admin_model->admin_table);
			$exists && exit('{"message":"该用户名已经存在！", "selector":"[name=login_name]"}');
			//密码
			$this->form_validation->required($POST['password']) OR exit('{"message":"登录密码不能为空！", "selector":"[name=password]"}');
			$POST['password'] = md5($POST['password']);
			$POST['reg_time'] = time();
			$data = elements(array('login_name', 'password', 'real_name', 'reg_time', 'status', 'email', 'group_id'), $POST);
			$this->admin_model->add_admin($data);
			echo '{"success":1, "message":"操作成功！", "redirect":"'.urldecode($_GET['redirect']).'"}';
		}
		else
		{
			$this->smarty->view('home/user/create.tpl');
		}
	}

	public function index()
	{
		if (!IS_AJAX)
        {
            parent::set_html_header();
            $data['page_title'] = '前台首页';
            $data['data_grid_url'] = '/user/index';
            $this->smarty->view('home/user/index.tpl', $data);
            return;
        }

        $this->load->model(
            array('user_model')
        );
        $map = array();
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');
        $sort && $order && $map['order_by'] = array($sort, $order);

        $uName = $this->input->get('uName');
        $uName && $map[] = 'uName LIKE "%'.$uName.'%"';

        $status = $this->input->get('status');
        $status != '' && $map[] = array('status'=>intval($status));
        $name = $this->input->get('name');
        $name != '' && $map[] = 'name LIKE "%'.$name.'%"';

        $page = intval($this->input->get('page'));
        $rows = intval($this->input->get('rows'));
        $map['limit'] = array($rows, ($page ? $page-1 : 0)*$rows);
        $list = $this->user_model->get_list($map);
        $list['sql'] = $this->user_model->last_query();
        $list['map'] = $map;
        echo json_encode($list);
	}

	/**
	 * 删除管理员
	 */
	public function delete_admin()
	{
		parent::set_json_header();
		if ($_POST) {
			$id_list = join(',', $_POST['id']);
			if ($id_list)
			{
				$this->admin_model->delete_admin('id in('.$id_list.')');
			}
			echo '{"success":1, "message":"操作成功！", "redirect":"'.urldecode($_GET['redirect']).'"}';
		} else {
			redirect('/admin/admin_list');
		}
	}

	/**
	 * 编辑管理员
	 */
	public function edit_admin($id)
	{
		$id = intval($id);
		$id == 1 && redirect('/admin/admin_list');
		if ($_POST)
		{
			parent::set_json_header();
			$this->load->library('form_validation');
			$this->load->helper('array_helper');
			$POST = deep_htmlspecialchars($_POST);
			$this->form_validation->required($POST['login_name']) OR exit('{"message":"登录名不能为空！", "selector":"[name=login_name]"}');
			$exists = $this->admin_model->exists('login_name="'.$POST['login_name'].'" AND id<>'.$id, $this->admin_model->admin_table);
			$exists && exit('{"message":"该用户名已经存在！", "selector":"[name=login_name]"}');
			//密码
			$POST['password'] && $POST['password'] = md5($POST['password']);
			$field_filter = array('login_name', 'real_name', 'status', 'email', 'group_id');
			$POST['password'] && $field_filter[] = 'password';
			$data = elements($field_filter, $POST);
			$this->admin_model->update_admin(array('id'=>$id), $data);
			echo '{"success":1, "message":"操作成功！", "redirect":"'.urldecode($_GET['redirect']).'"}';
		}
		else
		{
			parent::set_html_header();
			$data['data'] = $this->admin_model->get_admin($id);
			$data['group_list'] = $this->admin_model->get_admin_group_list();
			$this->smarty->view('admin/admin/edit_admin.tpl', $data);
		}
	}

}