<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
defined('WIDGET') OR show_404();

class Favorite extends HOME_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(
			array('role_model')
		);
	}

	public function menu($data)
	{
		$userId = 1; //todo 登陆用户id
		$this->load->model(
			array(
				'node_model', 'favorite_menu_model'
			)
		);
		$nodeIds   = $this->favorite_menu_model->get_list(array('userId'=>$userId), 'nodeId');
		$menus = array();
		foreach($nodeIds['rows'] as $row) {
			$menus[] = $this->node_model->get_row($row['nodeId'], 'code,name,id');
		}

		$assign['nodeList'] = $menus;
		$assign['width'] = '100';

		$this->smarty->view('home/widget/favorite/menu.tpl', $assign);
	}
}

/* End of file favorite.php */
/* Location: ./application/controllers/favorite.php */