<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Select extends HOME_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 选择角色
	 * @param $userId
	 */
	public function role($userId){
		$this->load->model('role_user_model');
		parent::set_html_header();

		//已选中角色
		$assign['roleUsers']         = $this->role_user_model->get_list(array('userId'=>$userId), 'roleId');
		$roleIds = '';
		$rows = $assign['roleUsers']['rows'];
		foreach($rows as $row) {
			$roleIds .= $roleIds !== ''  ?  ','.$row['roleId'] : $row['roleId'];
		}
		$assign['roleIds'] = $roleIds;
		$assign['searchBlockHeight'] = 42;
		$assign['userId']            = $userId;
		$assign['data_grid_url']     = '/role/index';

		$this->smarty->view('home/select/role.tpl', $assign);
	}

	/**
	 * 选择用户
	 * @param $roleId
	 */
	public function user($roleId){
		$this->load->model('role_user_model');
		parent::set_html_header();

		//已选中角色
		$assign['roleUsers']         = $this->role_user_model->get_list(array('roleId'=>$roleId), 'userId');
		$userIds = '';
		$rows = $assign['roleUsers']['rows'];
		foreach($rows as $row) {
			$userIds .= $userIds !== ''  ?  ','.$row['userId'] : $row['userId'];
		}
		$assign['userIds']           = $userIds;
		$assign['roleId']            = $roleId;
		$assign['data_grid_url']     = '/user/index';

		$this->smarty->view('home/select/user.tpl', $assign);
	}
}

/* End of file select.php */
/* Location: ./application/controllers/select.php */